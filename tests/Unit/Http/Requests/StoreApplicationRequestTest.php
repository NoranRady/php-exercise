<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
use App\Http\Requests\StoreApplicationRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class StoreApplicationRequestTest extends TestCase
{
    public function testInvalidCompanyId()
    {
        // Create a new request with an invalid company_id
        $request = new StoreApplicationRequest();
        $validationFactory = $this->app->make(ValidationFactory::class);

        $validator = $validationFactory->make(['company_id' => 'invalid'], $request->rules());

        // Check that a response with an error message is returned
        $this->assertTrue($validator->fails());
        $this->assertEquals(
            'The selected company id is invalid.',
            $validator->errors()->first('company_id')
        );
    }

    public function testInvalidStartDate()
    {
        $request = new StoreApplicationRequest();
        $validationFactory = $this->app->make(ValidationFactory::class);

        $validator = $validationFactory->make(['company_id' => '1', 'start_date' => '2023-05-29'], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals(
            'The start date field must be a date before or equal to end date.',
            $validator->errors()->first('start_date')
        );
    }

    public function testAuthorization()
    {
        $request = new StoreApplicationRequest();

        $this->assertTrue($request->authorize());
    }

    public function testValidationMessages()
    {
        // Create a new request
        $request = new StoreApplicationRequest();

        // Define the input data
        $data = [
            'company_id' => '',
            'start_date' => 'invalid_date',
            'end_date' => '2022-12-31',
            'email' => 'invalid_email'
        ];

        $validationFactory = $this->app->make(ValidationFactory::class);

        $validator = $validationFactory->make($data, $request->rules(), $request->messages());

        // Assert that the validator fails
        $this->assertTrue($validator->fails());

        // Assert that the error messages are correct
        $this->assertEquals([
            'company_id' => [
                'The company id field is required.'
            ],
            'start_date' => [
                'The start date must be a valid date.'
            ],
            'email' => [
                'The email must be a valid email address.'
            ]
        ], $validator->errors()->toArray());
    }

    public function test_failed_validation_returns_http_response_exception()
    {
        $validator = ValidatorFacade::make([], []);
        $request = new StoreApplicationRequest();
        $exception = null;

        try {
            $request->failedValidation($validator);
        } catch (HttpResponseException $e) {
            $exception = $e;
        }

        $this->assertInstanceOf(HttpResponseException::class, $exception);
        $this->assertEquals(422, $exception->getResponse()->getStatusCode());
        $this->assertEquals(json_encode([
            'error' => 'Invalid Input',
            'messages' => $validator->errors(),
        ]), $exception->getResponse()->getContent());
    }
}
