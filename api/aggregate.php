<?php

header("Content-Type: application/json");

$sources = [
    "../data/technology.json",
    "../data/education.json",
    "../data/travel.json",
    "../data/entertainment.json"
];

$allPosts = [];

foreach ($sources as $sourceFile) {

    if (file_exists($sourceFile)) {

        $jsonData = file_get_contents($sourceFile);

        $data = json_decode($jsonData, true);

        if ($data && isset($data["posts"])) {

            foreach ($data["posts"] as $post) {

                $post["source"] = $data["source"];

                $allPosts[] = $post;
            }
        }
    }
}

echo json_encode([
    "success" => true,
    "total_posts" => count($allPosts),
    "posts" => $allPosts
]);

?>