<?php

header("Content-Type: application/json; charset=UTF-8");

function addBackupElement($xml, $parent, $name, $value)
{
    $element = $xml->createElement($name);

    $element->appendChild(
        $xml->createTextNode((string)$value)
    );

    $parent->appendChild($element);
}

try {

    $files = [
        __DIR__ . "/../data/technology.json",
        __DIR__ . "/../data/education.json",
        __DIR__ . "/../data/travel.json",
        __DIR__ . "/../data/entertainment.json"
    ];

    $allPosts = [];

    foreach ($files as $file) {

        if (!file_exists($file)) {
            throw new Exception(
                "File not found: " . basename($file)
            );
        }

        $data = json_decode(
            file_get_contents($file),
            true
        );

        if ($data === null) {
            throw new Exception(
                "Invalid JSON: " . basename($file)
            );
        }

        if (isset($data["posts"])) {
            $allPosts = array_merge(
                $allPosts,
                $data["posts"]
            );
        }
    }


    $xml = new DOMDocument(
        "1.0",
        "UTF-8"
    );

    $xml->formatOutput = true;


    $feed =
        $xml->createElement("feed");

    $xml->appendChild($feed);


    $generatedAt =
        $xml->createElement(
            "generated_at"
        );

    $generatedAt->appendChild(
        $xml->createTextNode(
            date("Y-m-d H:i:s")
        )
    );

    $feed->appendChild($generatedAt);


    foreach ($allPosts as $post) {

        $postElement =
            $xml->createElement("post");

        addBackupElement(
            $xml,
            $postElement,
            "id",
            $post["id"] ?? ""
        );

        addBackupElement(
            $xml,
            $postElement,
            "username",
            $post["username"] ?? ""
        );

        addBackupElement(
            $xml,
            $postElement,
            "category",
            $post["category"] ?? ""
        );

        addBackupElement(
            $xml,
            $postElement,
            "content",
            $post["content"] ?? ""
        );

        addBackupElement(
            $xml,
            $postElement,
            "likes",
            $post["likes"] ?? 0
        );

        addBackupElement(
            $xml,
            $postElement,
            "comments",
            $post["comments"] ?? 0
        );

        addBackupElement(
            $xml,
            $postElement,
            "time",
            $post["time"] ?? ""
        );

        $feed->appendChild(
            $postElement
        );
    }


    $xml->insertBefore(

        $xml->createProcessingInstruction(
            "xml-stylesheet",
            'type="text/xsl" href="../xslt/feed.xsl"'
        ),

        $xml->documentElement
    );


    $backupFolder =
        __DIR__ . "/../backup";


    if (!is_dir($backupFolder)) {

        mkdir(
            $backupFolder,
            0777,
            true
        );
    }


    $xmlFile =
        $backupFolder .
        "/feed_backup.xml";


    if ($xml->save($xmlFile) === false) {

        throw new Exception(
            "Unable to save XML backup."
        );
    }


    echo json_encode([

        "success" => true,

        "message" =>
            "XML backup created successfully!",

        "total_posts" =>
            count($allPosts)

    ]);

}
catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" =>
            $e->getMessage()

    ]);
}

?>