<?php

namespace App\Traits;

trait RadiusHelper
{
    public function isValidMacAddress($macAddress) {
        $pattern = '/^([0-9A-Fa-f]{2})([:-]?)([0-9A-Fa-f]{2})(\2[0-9A-Fa-f]{2}){4}$/';
    
        return preg_match($pattern, $macAddress) === 1;
    }

    public function convertMacAddress($macAddress) {
        // Remove any existing colons or hyphens from the input string
        $macAddress = str_replace([':', '-'], '', $macAddress);
    
        // Insert colons after every 2 characters if necessary
        if (strlen($macAddress) === 12) {
            $macAddress = implode(':', str_split($macAddress, 2));
        }
    
        return $macAddress;
    }

    public function chapVerify($password,$chap_password,$chap_challenge) {
        
        //Clean CHAP
        $chap_password = count(explode('0x',$chap_password)) == 1 ? $chap_password : explode('0x',$chap_password)[1];
        $chap_challenge = count(explode('0x',$chap_challenge)) == 1 ? $chap_challenge : explode('0x',$chap_challenge)[1];

        $chap_password = hex2bin($chap_password);
        $chap_challenge = hex2bin($chap_challenge);

        $chapId = $chap_password[0];

        $encrypted_password = md5($chapId . $password . $chap_challenge);
        $requested_password = $this->hex_dump(substr($chap_password,1));

        return $encrypted_password === $requested_password;
    }

    public function getAttribute($attr_name, $radSwoole = true) {
        if($radSwoole) {
            return request()->input($attr_name) ?? null;
        }
        return request()->input($attr_name,[
            'value' => [null]
        ])['value'][0] ?? null;
    }

    public function isRandomMac($macAddress) {
        // Remove any non-hexadecimal characters from the MAC address
        $sanitizedMac = preg_replace('/[^a-fA-F0-9]/', '', $macAddress);
    
        // Ensure the MAC address has exactly 12 hexadecimal digits
        if (strlen($sanitizedMac) !== 12) {
            return false;
        }
    
        // Convert the first octet (most significant octet) to binary
        $binaryFirstOctet = base_convert(substr($sanitizedMac, 0, 2), 16, 2);
    
        // Check if the 2nd least significant bit is set to 1
        if (strlen($binaryFirstOctet) >= 2 && $binaryFirstOctet[strlen($binaryFirstOctet) - 2] === '1') {
            return true;
        }
    
        return false;
    }

    public function getPublicToken($checkStr) {

        $nasTypes = [
            'mikrotik',
            'tplink',
            'other'
        ];

        $str = explode('.',$checkStr);

        if(count($str) == 4) {
            if(in_array($str[0], $nasTypes)) {
                return $str;
            }
        } 

        return [null,null,null,null];
    }

    public function convertBytes($bytes)
    {
        $units = ['B', 'Kb', 'Mb', 'Gb'];
        $index = 0;
        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }
        return round($bytes, 2) . ' ' . $units[$index];
    }

    public function convertSeconds($seconds)
    {
        $days = floor($seconds / (60 * 60 * 24));
        $hours = floor(($seconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($seconds % (60 * 60)) / 60);
    
        $result = '';
        if ($days > 0) {
            $result .= $days . ' day' . ($days > 1 ? 's' : '') . ' ';
        }
        if ($hours > 0) {
            $result .= $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ';
        }
        if ($minutes > 0) {
            $result .= $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ';
        }
    
        return trim($result);
    }

    public function radiusCoa($command,$attributes, $radiusSecret, $nasIP, $port = 3799) {
        // Prepare attributes string
        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= "$key=$value\n";
        }
        
        // Construct the radclient command
        $command = "echo '$attributesStr' | radclient -x -r 1 $nasIP:$port $command $radiusSecret";
        
        // Execute the command
        exec($command, $output, $return_var);
        
        // Check for success or handle errors
        if ($return_var === 0) {
            return true; // CoA request sent successfully
        } else {
            return false; // Error sending CoA request
        }
    }

    
}