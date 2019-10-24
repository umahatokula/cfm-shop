<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pin;

class Pin extends Model
{
    public function transactions() {
        return $this->hasMany('App\Transaction');
    }


    /**
     * [generate description]
     * @return [type] [description]
    */
    public function generatePIN($PIN_length = 8) {

        $PIN_found = false;

        while (!$PIN_found) {

        $PIN = "";

        $i = 0;

        while ($i < $PIN_length) {

            //generate a random number between 0 and 9.
            $PIN .= mt_rand(0, 9);
            $i++;

        }

        $result = Pin::where('pin', $PIN)->first();

        if (is_null($result)) {
            $PIN_found = true;
        }

        return $PIN;

        }
    }
}
