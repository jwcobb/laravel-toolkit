<?php

namespace JWCobb\LaravelToolkit\Models\Presenters;

use TheHiveTeam\Presentable\Presenter;

class PhoneNumberPresenter extends Presenter
{
    function formattedPhoneNumber($format = 'ITUE123', $extensionSeparator = ' Ext:')
    {
        $newNum = $this->model->country_code.$this->model->number;

        $cleanNumber = preg_replace('/\D/', '', $number);

        $length = strlen($cleanNumber);

        switch ($length) {
            case 13:
                $newNum = substr($cleanNumber, 0, 3).' '.substr($cleanNumber, 3, 3).' '.substr(
                        $cleanNumber,
                        6,
                        3
                    ).' '.substr($cleanNumber, 9, 4);
                break;

            case 12:
                $newNum = '+'.substr($cleanNumber, 0, 3).' '.substr($cleanNumber, 3, 2).' '.substr(
                        $cleanNumber,
                        5,
                        3
                    ).' '.substr($cleanNumber, 8, 4);
                break;

            case 11:
                if (substr($cleanNumber, 0, 1) == '1') {
                    $newNum = '+'.substr($cleanNumber, 0, 1).' '.substr(
                            $cleanNumber,
                            1,
                            3
                        ).' '.substr($cleanNumber, 4, 3).' '.substr($cleanNumber, 7, 4);
                } else {
                    $newNum = '+'.substr($cleanNumber, 0, 2).' '.substr(
                            $cleanNumber,
                            2,
                            2
                        ).' '.substr($cleanNumber, 4, 3).' '.substr($cleanNumber, 7, 4);
                }

                break;
            case 10:
                if ($format === 'hyphen') {
                    $newNum = substr($cleanNumber, 0, 3).'-'.substr($cleanNumber, 3, 3).'-'.substr(
                            $cleanNumber,
                            6,
                            4
                        );
                } else {
                    $newNum = '('.substr($cleanNumber, 0, 3).') '.substr(
                            $cleanNumber,
                            3,
                            3
                        ).'-'.substr($cleanNumber, 6, 4);
                }
                break;

            case 9:
                $newNum = substr($cleanNumber, 0, 2).' '.substr($cleanNumber, 2, 3).' '.substr(
                        $cleanNumber,
                        5,
                        2
                    ).' '.substr($cleanNumber, 7, 2);
                break;

            case 8:
                $newNum = substr($cleanNumber, 0, 4).' '.substr($cleanNumber, 3, 4);
                break;

            case 7:
                $newNum = substr($cleanNumber, 0, 3).'-'.substr($cleanNumber, 3, 4);
                break;

            default:
                $newNum = $cleanNumber;
        }

        if ($this->model->extension !== null) {
            return $newNum.$extensionSeparator.$this->model->extension;
        }

        return $newNum;
    }
}
