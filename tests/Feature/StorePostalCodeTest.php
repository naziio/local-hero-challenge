<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\StorePostalCodeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorePostalCodeTest extends TestCase
{

 /** @var StorePostalCodeRequest */
 private $subject;

 protected function setUp(): void
 {
     parent::setUp();

     $this->subject = new StorePostalCodeRequest();
 }

 public function testRules()
 {
     $this->assertEquals([
        'postal_code' => 'required|between:4,5',
    ],
         $this->subject->rules()
     );
 }

 public function testAuthorize()
 {
     $this->assertTrue($this->subject->authorize());
 }
}
