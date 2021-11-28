<?php

namespace JWCobb\LaravelToolkit\Models\Presenters;

use TheHiveTeam\Presentable\Presenter;

class AddressPresenter extends Presenter
{
    /**
     * Formats a street address.
     */
    public function formattedAddress(): string
    {
        $string = '<address>';

        if (! empty($this->model->address_line_1)) {
            $string .= '<span class="street-address-line-1">'.$this->model->address_line_1.'</span><br>';
        }
        if (! empty($this->model->address_line_2)) {
            $string .= '<span class="street-address-line-2">'.$this->model->address_line_2.'</span><br>';
        }
        if (! empty($this->model->address_line_3)) {
            $string .= '<span class="street-address-line-3">'.$this->model->address_line_3.'</span><br>';
        }
        if (! empty($this->model->locality) && ! empty($this->model->region) && ! empty($this->model->postal_code)) {
            $string .= '<span class="street-address-locality">'.$this->model->locality.'</span>, <span class="street-address-region">'.$this->model->region.'</span> <span class="street-address-postal-code">'.$this->model->postal_code.'</span>';
        } elseif (! empty($this->model->locality) && ! empty($this->model->region)) {
            $string .= '<span class="street-address-locality">'.$this->model->locality.'</span>, <span class="street-address-region">'.$this->model->region.'</span>';
        } else {
            $string = implode(' ', [$this->model->locality, $this->model->region, $this->model->postal_code]);
        }
        if (! empty($this->model->country_code) && $this->model->country_code !== 'US') {
            $string .= ' <span class="street-address-country-code">'.$this->model->country_code.'</span><br>';
        }
        $string .= '</address>';

        return $string;
    }


    /**
     * Formats a street address
     */
    public function formattedAsGoogleMapsUrl(): string
    {
        $string = 'https://www.google.com/maps/place/';
        if (is_numeric(substr($this->model->address_line_1, 0, 1))) {
            $string .= urlencode(implode(' ', [
                $this->model->address_line_1 ?? '',
                $this->model->address_line_2 ?? '',
                $this->model->address_line_3 ?? '',
                $this->model->locality ?? '',
                $this->model->region ?? '',
                $this->model->postal_code ?? '',
            ]));
        } elseif (is_numeric(substr($this->model->address_line_2, 0, 1))) {
            $string .= urlencode(implode(' ', [
                $this->model->address_line_2 ?? '',
                $this->model->address_line_3 ?? '',
                $this->model->locality ?? '',
                $this->model->region ?? '',
                $this->model->postal_code ?? '',
            ]));
        } elseif (is_numeric(substr($this->model->address_line_2, 0, 1))) {
            $string .= urlencode(implode(' ', [
                $this->model->address_line_3 ?? '',
                $this->model->locality ?? '',
                $this->model->region ?? '',
                $this->model->postal_code ?? '',
            ]));
        }

        if (! empty($this->model->latitude) && ! empty($this->model->longitude)) {
            $string .= '/@'.urlencode($this->model->latitude).','.urlencode($this->model->longitude).',17z/';
        }

        return $string;
    }
}
