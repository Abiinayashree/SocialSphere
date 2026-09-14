<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output
        method="html"
        encoding="UTF-8"
        omit-xml-declaration="yes"/>


    <xsl:template match="/">

        <html>

            <head>

                <meta charset="UTF-8"/>

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"/>

                <title>
                    SocialSphere - XML Feed
                </title>


                <style>

                    * {
                        box-sizing: border-box;
                    }

                    body {
                        margin: 0;
                        padding: 30px;
                        font-family: Arial, sans-serif;
                        background: #f4f7fb;
                        color: #1f2937;
                    }

                    .container {
                        max-width: 1000px;
                        margin: auto;
                    }

                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                    }

                    h1 {
                        margin: 0;
                        font-size: 32px;
                    }

                    .subtitle {
                        margin-top: 8px;
                        color: #6b7280;
                    }

                    .count {
                        display: inline-block;
                        margin-top: 15px;
                        padding: 7px 14px;
                        background: #e0e7ff;
                        color: #3730a3;
                        border-radius: 20px;
                        font-size: 13px;
                        font-weight: bold;
                    }

                    .post {
                        background: white;
                        padding: 22px;
                        margin: 18px 0;
                        border-radius: 16px;
                        border: 1px solid #e5e7eb;
                        box-shadow:
                            0 5px 18px
                            rgba(0,0,0,0.06);
                    }

                    .top {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        gap: 15px;
                    }

                    .user {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                    }

                    .avatar {
                        width: 42px;
                        height: 42px;
                        border-radius: 50%;
                        background: #4f46e5;
                        color: white;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: bold;
                        font-size: 18px;
                    }

                    .username {
                        font-size: 18px;
                        font-weight: bold;
                    }

                    .source {
                        color: #2563eb;
                        font-size: 12px;
                        font-weight: bold;
                        margin-top: 3px;
                    }

                    .category {
                        display: inline-block;
                        margin: 16px 0 12px;
                        padding: 6px 12px;
                        background: #eef2ff;
                        color: #4338ca;
                        border-radius: 20px;
                        font-size: 12px;
                        font-weight: bold;
                    }

                    .content {
                        font-size: 16px;
                        line-height: 1.7;
                        color: #374151;
                    }

                    .stats {
                        margin-top: 18px;
                        padding-top: 14px;
                        border-top: 1px solid #edf0f3;
                        color: #6b7280;
                        font-size: 13px;
                    }

                    .time {
                        color: #9ca3af;
                    }

                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        color: #9ca3af;
                        font-size: 13px;
                    }

                    @media(max-width: 600px) {

                        body {
                            padding: 15px;
                        }

                        h1 {
                            font-size: 25px;
                        }

                        .post {
                            padding: 17px;
                        }

                        .top {
                            align-items: flex-start;
                        }

                        .username {
                            font-size: 16px;
                        }

                        .content {
                            font-size: 14px;
                        }

                    }

                </style>

            </head>


            <body>

                <div class="container">


                    <div class="header">

                        <h1>
                            🌐 SocialSphere XML Feed
                        </h1>

                        <div class="subtitle">
                            XML data transformed using XSLT
                        </div>

                        <div class="count">

                            Total Posts:
                            <xsl:value-of
                                select="count(/feed/post)"/>

                        </div>

                    </div>


                    <!-- POSTS -->

                    <xsl:for-each select="/feed/post">

                        <div class="post">


                            <div class="top">

                                <div class="user">

                                    <div class="avatar">

                                        <xsl:value-of
                                            select="substring(username, 1, 1)"/>

                                    </div>

                                    <div>

                                        <div class="username">

                                            <xsl:value-of
                                                select="username"/>

                                        </div>

                                        <div class="source">

                                            Source:
                                            <xsl:value-of
                                                select="source"/>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="category">

                                <xsl:value-of
                                    select="category"/>

                            </div>


                            <div class="content">

                                <xsl:value-of
                                    select="content"/>

                            </div>


                            <div class="stats">

                                ❤️ Likes:
                                <xsl:value-of
                                    select="likes"/>

                                <xsl:text> | </xsl:text>

                                💬 Comments:
                                <xsl:value-of
                                    select="comments"/>

                                <xsl:text> | </xsl:text>

                                🕒
                                <span class="time">

                                    <xsl:value-of
                                        select="time"/>

                                </span>

                            </div>

                        </div>

                    </xsl:for-each>


                    <div class="footer">

                        SocialSphere · XML + XSLT Feed Viewer

                    </div>


                </div>

            </body>

        </html>

    </xsl:template>

</xsl:stylesheet>