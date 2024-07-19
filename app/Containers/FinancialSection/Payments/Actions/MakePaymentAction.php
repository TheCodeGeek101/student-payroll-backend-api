<?php

namespace App\Containers\FinancialSection\Payments\Actions;

use App\Ship\Actions\Action;
use App\Containers\FinancialSection\Payments\Requests\PaymentRequest;
use App\Containers\UsersSection\Students\Data\Models\Student;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use Exception;

class MakePaymentAction extends Action
{
    public function run(PaymentRequest $request, Student $student)
    {
        // Retrieve PayChangu credentials and endpoint from environment variables
        $payChanguEndpoint = env('PAYCHANGU_ENDPOINT');
        $payChanguApiKey = env('PAYCHANGU_API_KEY');

        // Validate that necessary environment variables are set
        if (!$payChanguEndpoint || !$payChanguApiKey) {
            Log::error('PayChangu credentials are not set in the environment variables.');
            throw new Exception('Payment service is not configured properly. Please contact support.');
        }

        // Generate a unique reference code
        $referenceCode = 'REF-' . strtoupper(uniqid());

        // Prepare request data for PayChangu API
        $requestData = [
            'amount' => $request->amount,
            'currency' => 'MWK',  // Assuming Malawian Kwacha
            'email' => $student->email,  // Assuming student's email is used for payment
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'callback_url' => 'https://your-callback-url.com',  // Replace with your callback URL
            'return_url' => 'https://your-return-url.com',  // Replace with your return URL
            'tx_ref' => uniqid(),  // Generate a unique transaction reference
            'meta' => 'Additional metadata',  // Optional: Replace with any additional metadata
            'uuid' => uniqid(),  // Generate a unique UUID
            'customization' => [
                'title' => 'Title of payment',
                'description' => 'Payment description',
            ],
        ];

        // Initialize Guzzle HTTP client
        $client = new GuzzleClient();

        try {
            // Make the API request to PayChangu
            $response = $client->request('POST', $payChanguEndpoint, [
                'json' => $requestData,
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $payChanguApiKey,
                ],
            ]);

            // Decode the response body
            $responseData = json_decode($response->getBody(), true);

            // Check if the payment was successful
            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                // Store payment record in the database
                $payment = new Payment([
                    'student_id' => $student->id,
                    'amount' => $request->amount,
                    'description' => 'Payment for tuition fees',  // Adjust as necessary
                    'date' => now(),  // Adjust as necessary
                    'received_by' => auth()->id(),  // Assuming authenticated user ID
                    'confirmed' => false,  // Set to false initially
                    'reference_code' => $referenceCode,  // Store the reference code
                ]);
                $payment->save();

                // Return the payment object or any relevant response
                return $payment;
            } else {
                // Handle unsuccessful payment
                Log::error('PayChangu Payment Failed: ' . json_encode($responseData));
                throw new Exception('Payment failed. PayChangu status: ' . $responseData['status']);
            }
        } catch (Exception $e) {
            // Handle exceptions, log errors, and return appropriate responses
            Log::error('PayChangu Payment Error: ' . $e->getMessage());
            throw new Exception('Payment failed. Please try again later.');
        }
    }
}
