<?php

use Ofaws\Sanitizer\Facades\Sanitizer;

test('will return a sanitized text after a given string', function () {
    $output = Sanitizer::after('Title: Test; Content: **Lorem** ipsum dolor sit amet, consectetur adipiscing elit.', 'Content');

    expect($output)->toEqual('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
});

test('will return a sanitized text between given strings', function () {
    $output = Sanitizer::between('Title: Test; Content: **Lorem** ipsum dolor sit amet, consectetur adipiscing elit.', 'Title', 'Content');

    expect($output)->toEqual('Test');
});

test('will return true if filename is an image', function () {
    $output = Sanitizer::checkIfImageFile('test.jpg');

    expect($output)->toEqual(true);
});

test('will return false if filename is not an image', function () {
    $output = Sanitizer::checkIfImageFile('test.doc');

    expect($output)->toEqual(false);
});

test('will return sanitized json decoded array', function () {
    $input = '```json {
  "name": "John Doe",
  "age": 30,
  "email": "johndoe@example.com",
  "isSubscribed": true,
  "roles": ["user", "admin"],
  "address": {
    "street": "123 Main St",
    "city": "Anytown",
    "state": "CA",
    "zip": "12345"
  }
}```';

    $output = Sanitizer::json($input);

    expect($output)->toBeArray();
});

test('will return valid markdown', function () {
    $output = Sanitizer::markdown('```markdown ##Title Some content ```');

    expect($output)->toEqual('##Title Some content');
});
