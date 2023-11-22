<?php

// PREVENT DIRECT ACCESS
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    // The file is being accessed directly
    http_response_code(403);
    header("Location: /chat/403/");
    exit;
}
// PREVENT DIRECT ACCESS

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <!-- Google Console Verification -->
        <meta name="google-site-verification" content="Ypc_O50xyYcRsv6t5OlfQYcCYE6oPsvqoFYubJ__8UY" />

        <!-- Default Settings -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- SEO -->
        <meta name="keywords" content="<?= $seo_keywords ?>" />
        <meta name="description" content="<?= $seo_description ?>" />
        <meta name="author" content="<?= $seo_author ?>" />

        <meta property="og:title" content="May-tricks">
        <meta property="og:description" content="<?= $seo_description ?>">
        <meta property="og:image" content="/may-tricks/.github/desktop.png">
        <meta property="og:url" content="https://alexlostorto.co.uk/may-tricks/">
        <meta property="og:type" content="website">

        <!-- Icons -->
        <link rel="icon" type="image/x-icon" href="/may-tricks/assets/icons/favicon.png">
        <link rel="manifest" href="/may-tricks/site.webmanifest">

        <!-- Styles -->
        <link href="/may-tricks/assets/lib/bootstrap.min.css" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

            :root {
                --light-primary: #DACAED;
                --primary: #D4BDE9;
                --secondary: #B28DDE;

                --white: #DFDDF3;
                --accent: #1C1A29;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html,
            body {
                width: 100%;
                height: 100%;
            }

            a {
                text-decoration: none;
                color: black;
            }

            input,
            button,
            textarea,
            select {
                margin: 0;
                padding: 0;
                border: none;
                outline: none;
                font-family: inherit;
                font-size: inherit;
                color: inherit;
                background: none;
                appearance: none;
            }

            /* Change selection color */
            ::selection {
                background-color: var(--secondary);
                color: black;
            }

            /* Fallback for older browsers */
            ::-moz-selection {
                background-color: var(--secondary);
                color: black;
            }
        </style>

        <!-- Hotjar -->
        <script defer>
        (function (h, o, t, j, a, r) {
            h.hj =
            h.hj ||
            function () {
                (h.hj.q = h.hj.q || []).push(arguments);
            };
            h._hjSettings = { hjid: 3560401, hjsv: 6 };
            a = o.getElementsByTagName("head")[0];
            r = o.createElement("script");
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, "https://static.hotjar.com/c/hotjar-", ".js?sv=");
        </script>

        <title><?= $site_title ?></title>
    </head>
    <body>