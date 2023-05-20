<?php
namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Mail\WelcomeEmail;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailTest extends TestCase
{
    public function testEmailIsSentToCorrectRecipient()
    {
        $application = [
            'company' => [
                'company_name' => 'Acme Inc.',
            ],
            'email' => 'johndoe@example.com',
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
        ];

        $email = new WelcomeEmail($application);

        Mail::fake();
        Mail::to($application['email'])->send($email);

        Mail::assertSent(WelcomeEmail::class, function ($mail) use ($application) {
            return $mail->hasTo($application['email']);
        });
    }

    public function testMessageEnvelopeIsCorrectlyDefined()
    {
        $application = [
            'company' => [
                'company_name' => 'Acme Inc.',
            ],
            'email' => 'johndoe@example.com',
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
        ];

        $email = new WelcomeEmail($application);
        $envelope = $email->envelope();

        $this->assertEquals($application['company']['company_name'], $envelope->subject);
        $this->assertEquals($application['email'], $envelope->to[0]->address);
    }

    public function testMessageContentIsCorrectlyDefined()
    {
        $application = [
            'company' => [
                'company_name' => 'Acme Inc.',
            ],
            'email' => 'johndoe@example.com',
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
        ];

        $email = new WelcomeEmail($application);
        $content = $email->content();
        $this->assertEquals('emails.creation', $content->view);
    }

    public function testAttachmentsAreCorrectlyDefined()
    {
        $application = [
            'company' => [
                'company_name' => 'Acme Inc.',
            ],
            'email' => 'johndoe@example.com',
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
        ];

        $email = new WelcomeEmail($application);
        $attachments = $email->attachments();

        $this->assertIsArray($attachments);
        $this->assertEmpty($attachments);
    }

}