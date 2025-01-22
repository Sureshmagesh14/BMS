<?php

namespace App\Services;

use SendGrid;
use SendGrid\Mail\Mail;
use Exception;

class SendGridService
{
    protected $sendgrid;
    protected $email;

    public function __construct()
    {
        // Initialize SendGrid client with API Key
        $this->sendgrid = new SendGrid(env('SENDGRID_API_KEY')); // Get SendGrid API Key from .env file

        // Create a new SendGrid Mail object
        $this->email = new Mail();
    }

    /**
     * Set the 'From' address for the email.
     *
     * @param string $from Email address of the sender
     * @param string|null $fromName Name of the sender (optional)
     * @return $this
     */
    public function setFrom($from = null, $fromName = 'Sender')
    {
        $from = $from ?: env('MAIL_FROM_ADDRESS'); // Default from address from .env
        $this->email->setFrom($from, $fromName);
        return $this;
    }

    /**
     * Set the subject of the email.
     *
     * @param string $subject Subject of the email
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->email->setSubject($subject);
        return $this;
    }

    /**
     * Set the SendGrid template ID.
     *
     * @param string $templateId The SendGrid template ID
     * @return $this
     */
    public function setTemplateId($templateId)
    {
        $this->email->setTemplateId($templateId);
        return $this;
    }

    /**
     * Set the dynamic data for the SendGrid template.
     *
     * @param array $dynamicData The dynamic data to populate the template
     * @return $this
     */
    public function setDynamicData($dynamicData)
{
    // Initialize an array for formatted dynamic data
    $formattedData = [];

    // Check if there's an 'insert' key and process its contents
    if (isset($dynamicData['insert']) && is_array($dynamicData['insert'])) {
        foreach ($dynamicData['insert'] as $key => $value) {
            $formattedData[$key] = $value;
        }
    }

    // Include direct dynamic data
    foreach ($dynamicData as $key => $value) {
        if ($key !== 'insert') {
            $formattedData[$key] = $value;
        }
    }

    \Log::info('Formatted Dynamic Data:', $formattedData);  // Log for debugging

    try {
        // Add dynamic template data to the email
        foreach ($formattedData as $key => $value) {
            $this->email->addDynamicTemplateData($key, $value);
        }
    } catch (Exception $e) {
        \Log::error("Error in adding dynamic template data:", [
            'error_message' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
            'dynamic_data' => $formattedData
        ]);
    }

    return $this;
}

    
    
    

    /**
     * Set the recipient email address.
     *
     * @param string $to Email address of the recipient
     * @param string|null $toName Name of the recipient (optional)
     * @return $this
     */
    public function setToEmail($to, $toName = null)
    {
        $toName = $toName ?: 'Recipient';
        $this->email->addTo($to, $toName);
        return $this;
    }

    /**
     * Send the email using SendGrid.
     *
     * @return mixed Response from SendGrid API
     */
    public function send()
    {
        try {
            $response = $this->sendgrid->send($this->email);
            return $response;
        } catch (Exception $e) {
            // If error occurs, return the error message
            return 'Caught exception: ' . $e->getMessage();
        }
    }
}
