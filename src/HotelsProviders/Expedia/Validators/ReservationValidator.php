<?php namespace HotelsProviders\Expedia\Validators;

class ReservationValidator
{
    public function validate($reservation, $rooms)
    {
        $erros = [];
        $rules = [
            'checkin_date'                 => 'required|date|after:'.date('Y-m-d', strtotime('yesterday')),
            'checkout_date'                => 'required_with:checkin_date|date_format:m/d/Y|after:'.$reservation['checkin_date'],
            'customer.translated-name'     => 'required',
            'customer.phone'               => 'required',
            'customer.email'               => 'required',
            'credit_card.translated-name'  => 'required',
            'credit_card.address_country'  => 'required',
            'credit_card.address_city'     => 'required',
            'credit_card.translated-2name'  => 'required',
            'credit_card.address_zip'      => 'required',
            'credit_card.address_line'     => 'required'
        ];

        $validator = \Validator::make($reservation, $rules);
        $validator->sometimes('credit_card.address_state', 'required', function($creditCard) {
            return in_array($creditCard['address_country'], ['US','CA','AU']);
        });

        if ($validator->fails()) {
            $errors [] =  $validator->messages()->getMessages();
        }
        $rules = [
            'is_prepaid'        => 'required',
            'accommodation_id'  => 'required',
            'code'              => 'required',
            'key'               => 'required',
            'bedType'           => 'required'
        ];
        foreach ($rooms as $room) {
            $validator = \Validator::make($room, $rules);

            if ($validator->fails()) {
                $errors [] =  $validator->messages()->getMessages();
            }
        }
        return $errors;
    }
}
