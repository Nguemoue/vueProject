<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/font/css/materialdesignicons.css">
    <link rel="stylesheet" href="../../includes/vuetify/dist/vuetify.css">
    <script>
        window.onload = function(){
            document.querySelector(".loader").classList.add("loaded");
        }
    </script>
    <style>
    .loader{
        display: flex;
        position: absolute;
        height: 100vh;
        width: 100vw;
        background: #444;
        color: yellow;
        opacity: 1;
        justify-content: center;
        align-items: center;
        font-size: 2em;
        transition: opacity .8s;
        visibility: visible;
    }
    .loaded{
    opacity: 0;
    visibility: hidden;
    }
    </style>
</head>
<body>
    <div class="loader">
        Chargement...
    </div>
