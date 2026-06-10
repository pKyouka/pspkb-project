<?php

test('frontend exposes the Google Translate language switcher', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('data-google-lang="id"', false)
        ->assertSee('data-google-lang="en"', false)
        ->assertSee('translate.google.com/translate_a/element.js', false);
});
