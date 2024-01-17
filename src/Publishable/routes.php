<?php

//Static routes
$this->get("/", function () {
    echo "Hello World";
});

//Dynamic routes
$this->get("/profile/{name}", function ($name) {
    echo "Hello $name";
});