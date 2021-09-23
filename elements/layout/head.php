<?php
include_once('functions/helper.php');
?>
<!doctype html>
<html class="no-js h-100" lang=<?= $lng ?>>

<head>
    <meta charset="utf-8">
    <title><?= $company->name ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="stylesheet" href="<?= auto_version('css/normalize.css') ?>" type="text/css">
    <?php if ($lng == "he") : ?>
        <link rel="stylesheet" href="<?= auto_version('css/rtl.css') ?>" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.rtl.min.css" integrity="sha384-LPvXVVAlyPoBSGkX8UddpctDks+1P4HG8MhT7/YwqHtJ40bstjzCqjj+VVVDhsCo" crossorigin="anonymous">
    <?php endif ?>

    <?php if ($lng != "he") : ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <?php endif ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <meta name="theme-color" content="#fafafa">
    <link rel="stylesheet" href="<?= auto_version('css/main.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= auto_version('css/style.css') ?>" type="text/css">


</head>