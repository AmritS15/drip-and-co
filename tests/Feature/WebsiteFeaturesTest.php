<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebsiteFeaturesTest extends TestCase
{
    public function test_chatbot_empty_message_returns_helpful_prompt(): void
    {
        $response = $this->postJson('/chatbot/reply', [
            'message' => '',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath(
            'reply',
            "Please type a message and we'll be happy to help."
        );
    }

    public function test_chatbot_shipping_and_tracking_reply_is_specific(): void
    {
        $response = $this->postJson('/chatbot/reply', [
            'message' => 'Shipping & tracking',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath(
            'reply',
            'Delivery and tracking information for your order is available in your account dashboard. Go to Order details to view status and tracking. Once dispatched, tracking details are provided by our third-party delivery partner. We ship across the UK; standard delivery typically takes 3–5 working days.'
        );
    }

    public function test_chatbot_returns_and_refunds_reply_points_to_dashboard_flow(): void
    {
        $response = $this->postJson('/chatbot/reply', [
            'message' => 'Returns & refunds',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath(
            'reply',
            'You can request a return from your account dashboard. Please open your order history, select View Details for the relevant order, and submit your return request from there. Returns are accepted within 30 days. If you need any assistance, our support team will be happy to help.'
        );
    }
}
