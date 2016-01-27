#!/usr/bin/env php
<?php
/**
 * Script for populating the conference database.
 *
 * Polls the joind.in API for a list of talks for a given conference, and
 * populates the conference database with those talks, and the related
 * speakers.
 *
 * If a speaker for a talk does not have a corresponding entry on joind.in,
 * allows you to provide a default URI and twitter handle to utilize.
 */

require __DIR__ . '/../vendor/autoload.php';

/**
 * Conference ID.
 *
 * Change this value to generate talks and speakers for a different conference.
 */
$conferenceId  = 4648;

/**
 * Default speaker URI
 *
 * Change this value to specify a different default speaker URI when a speaker does not have an entry on joind.in.
 */
$defaultSpeakerUri = 'https://conference.phpbenelux.eu/2016/';

/**
 * Default speaker twitter username
 *
 * Change this value to specify a different default speaker twitter username when a speaker does not have an entry on joind.in.
 */
$defaultSpeakerTwitter = 'phpbenelux';

$dbPath        = realpath(__DIR__ . '/../data/db/conference.db');
$pdo           = new Pdo('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$insertSpeaker = $pdo->prepare(
    'INSERT INTO speakers (id, name, url, twitter) VALUES (:id, :name, :url, :twitter)'
);
$insertTalk    = $pdo->prepare(
    'INSERT INTO talks (id, title, abstract, day, start_time) VALUES (:id, :title, :abstract, :day, :start_time)'
);
$insertLink    = $pdo->prepare(
    'INSERT INTO talks_speakers (talk_id, speaker_id) VALUES (:talk_id, :speaker_id)'
);

printf("Fetching talks for PHP Benelux 2016...");
$api = sprintf(
    'http://api.joind.in/v2.1/events/%d/talks?verbose=yes&resultsperpage=0',
    $conferenceId
);
$payload = json_decode(file_get_contents($api));
$talks    = $payload->talks;
printf("[DONE]\n");

$speakersInserted    = [];
$unknownSpeakerIndex = 100000;
foreach ($talks as $talk) {
    // Remove the events that are not talk related with speakers
    if (empty($talk->speakers)) {
      continue;
    }
    printf("Processing talk %s ... ", $talk->uri);
    $talkId = substr($talk->uri, strrpos($talk->uri, '/') + 1);

    $date = new DateTime($talk->start_date);

    $insertTalk->execute([
        ':id'         => (int) $talkId,
        ':title'      => $talk->talk_title,
        ':abstract'   => $talk->talk_description,
        ':day'        => $date->format('Y-m-d'),
        ':start_time' => $date->format('H:m'),
    ]);
    printf("[DONE]\n");

    foreach ($talk->speakers as $index => $speaker) {
        if (isset($speakersInserted[$speaker->speaker_name])) {
            printf("    Linking to speaker %s ... ", $speaker->speaker_name);
            $speaker->id = $speakersInserted[$speaker->speaker_name];
            $insertLink->execute([':talk_id' => $talkId, ':speaker_id' => $speaker->id]);
            printf("[DONE]\n");
            continue;
        }

        if (isset($speaker->speaker_uri)) {
            printf("    Fetching info for speaker %s ... ", $speaker->speaker_name);
            $id = (int) substr($speaker->speaker_uri, strrpos($speaker->speaker_uri, '/') + 1);
            $payload = json_decode(file_get_contents($speaker->speaker_uri));
            $users                  = $payload->users;
            $speaker                = array_shift($users);
            $speaker->id            = $id;
            $speaker->speaker_name  = $speaker->full_name;
            $talk->speakers[$index] = $speaker;
            printf("[DONE]\n");
        } else {
            $speaker->id               = $unknownSpeakerIndex++;
            $speaker->website_uri      = $defaultSpeakerUri;
            $speaker->twitter_username = $defaultSpeakerTwitter;
        }

        printf("    Inserting speaker %s ... ", $speaker->speaker_name);
        $insertSpeaker->execute([
            ':id'      => $speaker->id,
            ':name'    => $speaker->speaker_name,
            ':url'     => $speaker->website_uri,
            ':twitter' => $speaker->twitter_username,
        ]);
        printf("[DONE]\n");

        printf("    Linking to speaker %s ... ", $speaker->speaker_name);
        $insertLink->execute([':talk_id' => $talkId, ':speaker_id' => $speaker->id]);
        printf("[DONE]\n");

        $speakersInserted[$speaker->speaker_name] = $speaker->id;
    }
}
