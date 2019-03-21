PHP Table of Contents
=============

[![Latest Stable Version](https://poser.pugx.org/ashtaev/toc/v/stable)](https://packagist.org/packages/ashtaev/toc)
[![Total Downloads](https://poser.pugx.org/ashtaev/toc/downloads)](https://packagist.org/packages/ashtaev/toc)
[![Latest Unstable Version](https://poser.pugx.org/ashtaev/toc/v/unstable)](https://packagist.org/packages/ashtaev/toc)
[![License](https://poser.pugx.org/ashtaev/toc/license)](https://packagist.org/packages/ashtaev/toc)

A lightweight PHP library, for generating table of contents in the style of Wikipedia.

## Screenshots

They're rendered using the sample templates provided in the [templates](templates/) directory,
which depend on Bootstrap 4. 
You can easily use your own custom HTML to render the table of contents instead.

Default template:

<img src="screenshot-toc.png" width="530px"><br/>

## Installation

Install with composer:

    composer require ashtaev/toc

## Basic usage

Here's a quick example using the defaults:

    <?php
    
    require '../vendor/autoload.php';

    use ashtaev\Toc;

    $toc = new Toc($post);

    ?>
   
      
      <!DOCTYPE html>
      <html>
      <head>
          <!-- The default, built-in template supports the Bootstrap 4 TOC styles. -->
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <link rel="stylesheet" href="css/toc.css">
      </head>
      <body>
      
      <h1>Lorem ipsum</h1>
      

        <?php 
          // Example of rendering the table of contents with the built-in template.

          echo $toc->getPostWhithToc(); 
        ?>
        
      </body>
    </html>

This will output the following:

    <p>Lorem ipsum... </p>

    <div class="border d-inline-block pr-4 pt-3 bg-light toc">
        <div class="ml-4 mb-2"><b>Content</b></div>
        <ol>
            <li><a href="#Lorem_ipsum_dolor" title="Lorem ipsum dolor">Lorem ipsum dolor</a></li>
            <li><a href="#Expedita_sint_temporibus" title="Expedita sint temporibus">Expedita sint temporibus</a></li>
            <li><a href="#Maiores_quas_suscipit" title="Maiores quas suscipit">Maiores quas suscipit</a>
                <ol>
                    <li><a href="#Delectus_laudantium_numquam" title="Delectus laudantium numquam">Delectus laudantium numquam</a></li>
                    <li><a href="#Eaque_quisquam_rem?" title="Eaque quisquam rem?">Eaque quisquam rem?</a></li>
                    <li><a href="#Deleniti_et_quia" title="Deleniti et quia">Deleniti et quia</a>
                        <ol>
                            <li><a href="#Facilis_iusto_maxime!" title="Facilis iusto maxime!">Facilis iusto maxime!</a></li>
                            <li><a href="#Beatae_eveniet_nesciunt" title="Beatae eveniet nesciunt">Beatae eveniet nesciunt</a></li>
                        </ol>
                    </li>
                    <li><a href="#Beatae_fugit_mollitia?" title="Beatae fugit mollitia?">Beatae fugit mollitia?</a></li>
                </ol>
            </li>
            <li><a href="#Fugit_in_maxime" title="Fugit in maxime">Fugit in maxime</a></li>
            <li><a href="#Odit_reprehenderit_soluta" title="Odit reprehenderit soluta">Odit reprehenderit soluta</a></li>
        </ol>
    </div>
    
    <h2><span id="Lorem_ipsum_dolor">"1. Lorem ipsum dolor</span></h2>
    
    <p>Lorem ipsum dolor...</p>
