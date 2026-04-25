<?php
require('../../vendor/stripe/stripe-php/init.php');
		//print "This is Stripe webhook listener";
		//die;
        print $payload = @file_get_contents('php://input');
		$event = null;

		try {
			$event = \Stripe\Event::constructFrom(
				json_decode($payload, true)
			);
		} catch(\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			exit();
		}

		// Handle the event
		switch ($event->type) {
			case 'checkout.session.completed':
				$paymentIntent = $event->data->object; // contains a \Stripe\CheckOutSession
				// Then define and call a method to handle the successful Checkout session.
				// handlePaymentIntentSucceeded($paymentIntent);
				
				//mail("jawwad.euro@gmail.com", "Schooladmin  payment request", var_dump($event->data->object));
				break;
			case 'payment_intent.succeeded':
				$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
				// Then define and call a method to handle the successful payment intent.
				// handlePaymentIntentSucceeded($paymentIntent);
				break;
			case 'payment_method.attached':
				$paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
				// Then define and call a method to handle the successful attachment of a PaymentMethod.
				// handlePaymentMethodAttached($paymentMethod);
				break;
			// ... handle other event types
			default:
				echo 'Received unknown event type ' . $event->type;
		}

		http_response_code(200);
?>		