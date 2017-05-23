<?php
    require_once __DIR__ . '.\..\vendor\autoload.php';



    $template = $twig->loadTemplate('hello.phtml');
    $params = array(
        'name' => 'Krzysztof',
            'friends' => array(
            array(
            'firstname' => 'John',
            'lastname' => 'Smith'
            ),
            array(
            'firstname' => 'Britney',
            'lastname' => 'Spears'
            ),
            array(
            'firstname' => 'Brad',
            'lastname' => 'Pitt'
            )
        )
    );
    $template->display($params);
?>