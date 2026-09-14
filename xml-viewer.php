<?php

/* =====================================================
   FILE PATHS
===================================================== */

$xmlFile =
    __DIR__ . "/backup/feed_backup.xml";

$xslFile =
    __DIR__ . "/xslt/feed.xsl";


/* =====================================================
   CHECK XML
===================================================== */

if (!file_exists($xmlFile)) {

    ?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>SocialSphere XML Viewer</title>

        <style>

            body {
                font-family: Arial, sans-serif;
                background: #f4f6f8;
                padding: 40px;
                text-align: center;
            }

            .box {
                max-width: 600px;
                margin: auto;
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            }

            a {
                display: inline-block;
                margin-top: 15px;
                padding: 10px 18px;
                background: #4f46e5;
                color: white;
                text-decoration: none;
                border-radius: 8px;
            }

        </style>

    </head>

    <body>

        <div class="box">

            <h2>XML Backup Not Found</h2>

            <p>
                Please create the XML backup first.
            </p>

            <a href="api/backup.php">
                Create XML Backup
            </a>

        </div>

    </body>

    </html>

    <?php

    exit;

}


/* =====================================================
   CHECK XSL
===================================================== */

if (!file_exists($xslFile)) {

    die(
        "Error: feed.xsl file not found."
    );

}


/* =====================================================
   LOAD XML
===================================================== */

libxml_use_internal_errors(true);


$xml =
    new DOMDocument();

if (!$xml->load($xmlFile)) {

    echo "<h2>XML loading failed.</h2>";

    foreach (
        libxml_get_errors()
        as $error
    ) {

        echo
            htmlspecialchars(
                $error->message
            ) . "<br>";

    }

    libxml_clear_errors();

    exit;

}


/* =====================================================
   LOAD XSL
===================================================== */

$xsl =
    new DOMDocument();

if (!$xsl->load($xslFile)) {

    echo "<h2>XSLT stylesheet loading failed.</h2>";

    foreach (
        libxml_get_errors()
        as $error
    ) {

        echo
            htmlspecialchars(
                $error->message
            ) . "<br>";

    }

    libxml_clear_errors();

    exit;

}


/* =====================================================
   XSLT PROCESSOR
===================================================== */

$processor =
    new XSLTProcessor();


if (
    !$processor->importStylesheet($xsl)
) {

    echo
        "<h2>XSLT stylesheet compilation failed.</h2>";

    exit;

}


/* =====================================================
   TRANSFORM
===================================================== */

$result =
    $processor->transformToXML($xml);


if ($result === false) {

    echo
        "<h2>Unable to transform XML using XSLT.</h2>";

    exit;

}


/* =====================================================
   OUTPUT
===================================================== */

echo $result;

?>