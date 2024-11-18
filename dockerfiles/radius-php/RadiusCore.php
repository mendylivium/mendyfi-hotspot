<?php

/**
 * Source: https://github.com/CodFrm/php-radius
 * Source: https://github.com/phpipam/phpipam
 * Source: https://github.com/dr4g0nsr/radius-server
 * 
 * Developed by Rommel A. Mendiola
 */

require("SocketServer.php");

class RadiusCore 
{
    private $requestAccess, $acctStart, $acctStop, $acctInterim;

    var $reverseAttributes = [];
    var $radiusAttributes = [];
    var $vendorReverseAttributes = [];
    var $vendorRadiusAttributes = [];

    var $radiusFormat = [
        'string'    =>  'S',
        'ipaddr'    =>  'A',
        'integer'   =>  'I'
    ];

    var $acctStatusType = [
        1 => 'Start',
        2 => 'Stop',
        3 => 'Interim-Update',
        7 => 'Accounting-On',
        8 => 'Accounting-Off'
    ];

    var $acctTerminationCause = [
        1 => 'User-Request',
        2 => 'Lost-Carrier',
        3 => 'Lost-Service',
        4 => 'Idle-Timeout',
        5 => 'Session-Timeout',
        6 => 'Admin-Reset',
        7 => 'Admin-Reboot',
        8 => 'Port-Error',
        9 => 'NAS-Error',
        10 => 'NAS-Request',
        11 => 'NAS-Reboot',
        12 => 'Port-Unneeded',
        13 => 'Port-Preempted',
        14 => 'Port-Suspended',
        15 => 'Service-Unavailable',
        16 => 'Callback',
        17 => 'User-Error',
        18 => 'Host-Request'
    ];

    var $radiusPacket   =   [];

    var $radiusIp       =   '0.0.0.0';
    var $radiusAuthPort =   1812;
    var $radiusAcctPort =   1813;
    var $radiusSecret   =   'mendify@2023';

    public function __construct($radiusIp = '0.0.0.0', $authPort = 1812, $acctPort = 1813, $secret = 'mendify@2023')
    {
        $this->radiusIp         =   $radiusIp;
        $this->radiusAuthPort   =   $authPort;
        $this->radiusAcctPort   =   $acctPort;
        $this->radiusSecret     =   $secret;

        //Radius Packet Codes
        $this->radiusPacket[1]  = 'Access-Request';
        $this->radiusPacket[2]  = 'Access-Accept';
        $this->radiusPacket[3]  = 'Access-Reject';
        $this->radiusPacket[4]  = 'Accounting-Request';
        $this->radiusPacket[5]  = 'Accounting-Response';
        $this->radiusPacket[11] = 'Access-Challenge';
        $this->radiusPacket[12] = 'Status-Server (experimental)';
        $this->radiusPacket[13] = 'Status-Client (experimental)';
        $this->radiusPacket[255] = 'Reserved';



        $this->radiusAttributes[1] = array('User-Name', 'S');
        $this->radiusAttributes[2] = array('User-Password', 'S');
        $this->radiusAttributes[3] = array('CHAP-Password', 'S'); // Type (1) / Length (1) / CHAP Ident (1) / String
        $this->radiusAttributes[4] = array('NAS-IP-Address', 'A');
        $this->radiusAttributes[5] = array('NAS-Port', 'I');
        $this->radiusAttributes[6] = array('Service-Type', 'I');
        $this->radiusAttributes[7] = array('Framed-Protocol', 'I');
        $this->radiusAttributes[8] = array('Framed-IP-Address', 'A');
        $this->radiusAttributes[9] = array('Framed-IP-Netmask', 'A');
        $this->radiusAttributes[10] = array('Framed-Routing', 'I');
        $this->radiusAttributes[11] = array('Filter-Id', 'T');
        $this->radiusAttributes[12] = array('Framed-MTU', 'I');
        $this->radiusAttributes[13] = array('Framed-Compression', 'I');
        $this->radiusAttributes[14] = array('Login-IP-Host', 'A');
        $this->radiusAttributes[15] = array('Login-service', 'I');
        $this->radiusAttributes[16] = array('Login-TCP-Port', 'I');
        $this->radiusAttributes[17] = array('(unassigned)', '');
        $this->radiusAttributes[18] = array('Reply-Message', 'T');
        $this->radiusAttributes[19] = array('Callback-Number', 'S');
        $this->radiusAttributes[20] = array('Callback-Id', 'S');
        $this->radiusAttributes[21] = array('(unassigned)', '');
        $this->radiusAttributes[22] = array('Framed-Route', 'T');
        $this->radiusAttributes[23] = array('Framed-IPX-Network', 'I');
        $this->radiusAttributes[24] = array('State', 'S');
        $this->radiusAttributes[25] = array('Class', 'S');
        $this->radiusAttributes[26] = array('Vendor-Specific', 'S');
        $this->radiusAttributes[27] = array('Session-Timeout', 'I');
        $this->radiusAttributes[28] = array('Idle-Timeout', 'I');
        $this->radiusAttributes[29] = array('Termination-Action', 'I');
        $this->radiusAttributes[30] = array('Called-Station-Id', 'S');
        $this->radiusAttributes[31] = array('Calling-Station-Id', 'S');
        $this->radiusAttributes[32] = array('NAS-Identifier', 'S');
        $this->radiusAttributes[33] = array('Proxy-State', 'S');
        $this->radiusAttributes[34] = array('Login-LAT-Service', 'S');
        $this->radiusAttributes[35] = array('Login-LAT-Node', 'S');
        $this->radiusAttributes[36] = array('Login-LAT-Group', 'S');
        $this->radiusAttributes[37] = array('Framed-AppleTalk-Link', 'I');
        $this->radiusAttributes[38] = array('Framed-AppleTalk-Network', 'I');
        $this->radiusAttributes[39] = array('Framed-AppleTalk-Zone', 'S');
        $this->radiusAttributes[60] = array('CHAP-Challenge', 'S');
        $this->radiusAttributes[61] = array('NAS-Port-Type', 'I');
        $this->radiusAttributes[62] = array('Port-Limit', 'I');
        $this->radiusAttributes[63] = array('Login-LAT-Port', 'S');
        $this->radiusAttributes[76] = array('Prompt', 'I');

        $this->radiusAttributes[40] = array('Acct-Status-Type','S');
        $this->radiusAttributes[41] = array('Acct-Delay-Time','S');
        $this->radiusAttributes[42] = array('Acct-Input-Octets','S');
        $this->radiusAttributes[43] = array('Acct-Output-Octets','S');
        $this->radiusAttributes[44] = array('Acct-Session-Id','S');
        $this->radiusAttributes[45] = array('Acct-Authentic','S');
        $this->radiusAttributes[46] = array('Acct-Session-Time','S');
        $this->radiusAttributes[47] = array('Acct-Input-Packets','S');
        $this->radiusAttributes[48] = array('Acct-Output-Packets','S');
        $this->radiusAttributes[49] = array('Acct-Terminate-Cause','S');
        $this->radiusAttributes[50] = array('Acct-Multi-Session-Id','S');
        $this->radiusAttributes[51] = array('Acct-Link-Count','S');
        $this->radiusAttributes[85] = array('Acct-Interim-Interval','S');


        foreach($this->radiusAttributes as $key => $val) {
            $this->reverseAttributes[$val[0]] = $key;
        }
    }

    function decodePackets($packet, &$attributes,$dynamicSecret = null)
    {
        $_data = unpack('ccode/cidentifier/nlength/a16authenticator', $packet);

        $code               = $_data['code'];
        $identifier         = $_data['identifier'];
        $packet_length      = $_data['length'];
        $authenticator      = $_data['authenticator'];

        // From IPAM
        // $code               = intval(ord(substr($packet, 0, 1)));
        // $identifier         = intval(ord(substr($packet, 1, 1)));
        // $packet_length      = (intval(ord(substr($packet, 2, 1))) * 256) + (intval(ord(substr($packet, 3, 1))));
        // $authenticator      = substr($packet, 4, 16);

        $attributes_content = substr($packet, 20, ($packet_length - 4 - 16));

        //Need for PAP Decryption
        $attributes['Authenticator'] = $authenticator;

        while (strlen($attributes_content) > 2) {
            $attribute_type = intval(ord(substr($attributes_content, 0, 1)));
            $attribute_length = intval(ord(substr($attributes_content, 1, 1)));
            $attribute_raw_value = substr($attributes_content, 2, $attribute_length - 2);
            $attributes_content = substr($attributes_content, $attribute_length);
            $attribute_value = $this->decodeAttribute($attribute_raw_value, $attribute_type);

            $attribute_info = $this->getAttributesInfo($attribute_type);
            if (26 == $attribute_type)
            {
                $vendor_array = $this->decodeVendorSpecific($attribute_value);
                foreach ($vendor_array as $vendor_one)
                {
                    if(isset($this->vendorRadiusAttributes[$vendor_one[0]][$vendor_one[1]])) {
                        $attributes[$this->vendorRadiusAttributes[$vendor_one[0]][$vendor_one[1]][0]] = $this->decodeAttributeFormat($vendor_one[2],$this->vendorRadiusAttributes[$vendor_one[0]][$vendor_one[1]][1]);
                    } else {
                        $attributes["Vendor-$vendor_one[0]-$vendor_one[1]"] = $vendor_one[2];
                    }
                }
            } elseif(2 == $attribute_type ) {
                $attributes[$attribute_info[0]] = $this->decodePap($attribute_raw_value, $authenticator, $this->radiusSecret);
                $attributes['User-Password-Raw'] = $attribute_raw_value;
            } elseif($attribute_type >= 40 && $attribute_type <= 51) {
                switch ($attribute_type) {
                    case 40:
                        $attributes[$attribute_info[0]] = $this->acctStatusType[unpack('N', $attribute_raw_value)[1]] ?? "Unkwown";
                        break;
                    case 49:
                        $attributes[$attribute_info[0]] = $this->acctTerminationCause[unpack('N', $attribute_raw_value)[1]] ?? unpack('N', $attribute_raw_value)[1];
                        break;
                    case 44:
                        $attributes[$attribute_info[0]] =  $attribute_raw_value;
                        break;
                    default:
                    $attributes[$attribute_info[0]] = unpack('N', $attribute_raw_value)[1];
                        break;
                }
            } else {
                $attributes[$attribute_info[0]] = $attribute_value;
            }
        }
        return [ 'identifier' => $identifier, 'authenticator' => $authenticator, 'code' => $code];
    }

    function decodeAttributeFormat($attribute_raw_value, $attribute_format)
    {
       
        $attribute_value = NULL;

    
        switch ($attribute_format)
        {
            case 'T': // Text, 1-253 octets containing UTF-8 encoded ISO 10646 characters (RFC 2279).
                $attribute_value = $attribute_raw_value;
                break;
            case 'S': // String, 1-253 octets containing binary data (values 0 through 255 decimal, inclusive).
                $attribute_value = $attribute_raw_value;
                break;
            case 'A': // Address, 32 bit value, most significant octet first.
                $attribute_value = ord(substr($attribute_raw_value, 0, 1)).'.'.ord(substr($attribute_raw_value, 1, 1)).'.'.ord(substr($attribute_raw_value, 2, 1)).'.'.ord(substr($attribute_raw_value, 3, 1));
                break;
            case 'I': // Integer, 32 bit unsigned value, most significant octet first.
                $attribute_value = (ord(substr($attribute_raw_value, 0, 1)) * 256 * 256 * 256) + (ord(substr($attribute_raw_value, 1, 1)) * 256 * 256) + (ord(substr($attribute_raw_value, 2, 1)) * 256) + ord(substr($attribute_raw_value, 3, 1));
                break;
            case 'D': // Time, 32 bit unsigned value, most significant octet first -- seconds since 00:00:00 UTC, January 1, 1970. (not used in this RFC)
                $attribute_value = NULL;
                break;
            default:
                $attribute_value = NULL;
        }
        
        return $attribute_value;
    }

    function decodeAttribute($attribute_raw_value, $attribute_code)
    {
       
        $attribute_value = NULL;

        if (isset($this->radiusAttributes[$attribute_code]))
        {
            switch ($this->radiusAttributes[$attribute_code][1])
            {
                case 'T': // Text, 1-253 octets containing UTF-8 encoded ISO 10646 characters (RFC 2279).
                    $attribute_value = $attribute_raw_value;
                    break;
                case 'S': // String, 1-253 octets containing binary data (values 0 through 255 decimal, inclusive).
                    $attribute_value = $attribute_raw_value;
                    break;
                case 'A': // Address, 32 bit value, most significant octet first.
                    $attribute_value = ord(substr($attribute_raw_value, 0, 1)).'.'.ord(substr($attribute_raw_value, 1, 1)).'.'.ord(substr($attribute_raw_value, 2, 1)).'.'.ord(substr($attribute_raw_value, 3, 1));
                    break;
                case 'I': // Integer, 32 bit unsigned value, most significant octet first.
                    $attribute_value = (ord(substr($attribute_raw_value, 0, 1)) * 256 * 256 * 256) + (ord(substr($attribute_raw_value, 1, 1)) * 256 * 256) + (ord(substr($attribute_raw_value, 2, 1)) * 256) + ord(substr($attribute_raw_value, 3, 1));
                    break;
                case 'D': // Time, 32 bit unsigned value, most significant octet first -- seconds since 00:00:00 UTC, January 1, 1970. (not used in this RFC)
                    $attribute_value = NULL;
                    break;
                default:
                    $attribute_value = NULL;
            }
        }
        return $attribute_value;
    }

    function encodeAttribute($attribute_value, $attribute_code)
    {
        $attribute_raw_value = '';

        if (isset($this->radiusAttributes[$attribute_code])) {
            switch ($this->radiusAttributes[$attribute_code][1]) {
                case 'T': // Text, 1-253 octets containing UTF-8 encoded ISO 10646 characters (RFC 2279).
                case 'S': // String, 1-253 octets containing binary data (values 0 through 255 decimal, inclusive).
                    $attribute_raw_value = $attribute_value;
                    break;
                case 'A': // Address, 32 bit value, most significant octet first.
                    $octets = explode('.', $attribute_value);
                    $attribute_raw_value .= chr($octets[0]) . chr($octets[1]) . chr($octets[2]) . chr($octets[3]);
                    break;
                case 'I': // Integer, 32 bit unsigned value, most significant octet first.
                    $attribute_raw_value .= chr(($attribute_value >> 24) & 0xFF);
                    $attribute_raw_value .= chr(($attribute_value >> 16) & 0xFF);
                    $attribute_raw_value .= chr(($attribute_value >> 8) & 0xFF);
                    $attribute_raw_value .= chr($attribute_value & 0xFF);
                    break;
                case 'D': // Time, 32 bit unsigned value -- seconds since 00:00:00 UTC, January 1, 1970 (not used in this RFC).
                    // Since this case is not used in this RFC, we can leave it as NULL or handle it as needed.
                    $attribute_raw_value = NULL;
                    break;
                default:
                    $attribute_raw_value = NULL;
            }
        }

        return $attribute_raw_value;
    }


    function encodeAttributeFormat($attribute_value, $attribute_format)
    {
        $attribute_raw_value = '';
        switch ($attribute_format) {
            case 'T': // Text, 1-253 octets containing UTF-8 encoded ISO 10646 characters (RFC 2279).
            case 'S': // String, 1-253 octets containing binary data (values 0 through 255 decimal, inclusive).
                $attribute_raw_value = $attribute_value;
                break;
            case 'A': // Address, 32 bit value, most significant octet first.
                $octets = explode('.', $attribute_value);
                $attribute_raw_value .= chr($octets[0]) . chr($octets[1]) . chr($octets[2]) . chr($octets[3]);
                break;
            case 'I': // Integer, 32 bit unsigned value, most significant octet first.
                $attribute_raw_value .= chr(($attribute_value >> 24) & 0xFF);
                $attribute_raw_value .= chr(($attribute_value >> 16) & 0xFF);
                $attribute_raw_value .= chr(($attribute_value >> 8) & 0xFF);
                $attribute_raw_value .= chr($attribute_value & 0xFF);
                break;
            case 'D': // Time, 32 bit unsigned value -- seconds since 00:00:00 UTC, January 1, 1970 (not used in this RFC).
                // Since this case is not used in this RFC, we can leave it as NULL or handle it as needed.
                $attribute_raw_value = NULL;
                break;
            default:
                $attribute_raw_value = NULL;
        }

        return $attribute_raw_value;
    }

    

    public function encodePackets(string $secret, int $code, int $identifier, string $reqAuthenticator, array $attr = [])
    {
        $attr_bin = '';
        foreach ($attr as $key1) {
            foreach($key1 as $key => $value) {
                $attr_bin .= $this->pack_attr($key, $value);
            }
        }
        $len = 20 + strlen($attr_bin);
        //MD5(Code+ID+Length+RequestAuth+Attributes+Secret)
        $send = pack('ccna16',
                $code, $identifier, $len,
                md5(chr($code) . chr($identifier) . pack('n', $len) .
                    $reqAuthenticator . $attr_bin . $secret, true)
            ) . $attr_bin;
        return $send;
    }

    public function pack_attr($code, string $data)
    {
        return pack('cc', $code, 2 + strlen($data)) . $data;
    }

    function getAttributesInfo($info_index)
    {
        if (isset($this->radiusAttributes[intval($info_index)]))
        {
            return $this->radiusAttributes[intval($info_index)];
        } else
        {
            return array('', '');
        }
    }

    function decodeVendorSpecific($vendor_specific_raw_value)
    {
        $result = array();
        $offset_in_raw = 0;
        $vendor_id = (ord(substr($vendor_specific_raw_value, 0, 1)) * 256 * 256 * 256) + (ord(substr($vendor_specific_raw_value, 1, 1)) * 256 * 256) + (ord(substr($vendor_specific_raw_value, 2, 1)) * 256) + ord(substr($vendor_specific_raw_value, 3, 1));
        $offset_in_raw += 4;
        while ($offset_in_raw < strlen($vendor_specific_raw_value))
        {
            $vendor_type = (ord(substr($vendor_specific_raw_value, 0 + $offset_in_raw, 1)));
            $vendor_length = (ord(substr($vendor_specific_raw_value, 1 + $offset_in_raw, 1)));
            $attribute_specific = substr($vendor_specific_raw_value, 2 + $offset_in_raw, $vendor_length);
            $result[] = array($vendor_id, $vendor_type, $attribute_specific);
            $offset_in_raw += ($vendor_length);
        }

        return $result;
    }

    function encodeVendorSpecific($vendor_id, $vendor_type, $attribute_specific)
    {
        $vendor_specific_raw_value = '';

        // Encode vendor_id
        $vendor_specific_raw_value .= chr(($vendor_id >> 24) & 0xFF);
        $vendor_specific_raw_value .= chr(($vendor_id >> 16) & 0xFF);
        $vendor_specific_raw_value .= chr(($vendor_id >> 8) & 0xFF);
        $vendor_specific_raw_value .= chr($vendor_id & 0xFF);

        // Encode vendor_type
        $vendor_specific_raw_value .= chr($vendor_type);

        // Encode vendor_length
        $vendor_length = strlen($attribute_specific) + 2;
        $vendor_specific_raw_value .= chr($vendor_length);

        // Encode attribute_specific
        $vendor_specific_raw_value .= $attribute_specific;

        return $vendor_specific_raw_value;
    }


    public function log($str)
    {
        echo "$str \r\n";
    }

    public function load_dictionary($file = "dictionary") {
        $dictionaryPath = "./dictionary/".$file;
        if (file_exists($dictionaryPath)) {
            $this->log("Load Dictionary " . $file);
            $dict = file_get_contents("./dictionary/" . $file);
            $dict_lines = explode("\n", $dict);
            $current_vendor = NULL;
            $current_vendorId = 0;
            foreach ($dict_lines as $dict_item) {
                if (strlen($dict_item) < 10 || $dict_item[0] == "#") {
                    continue;
                } else
                if (substr($dict_item, 0, 8) == "\$INCLUDE") {
                    $dict_file = trim(substr($dict_item, 9));
                    $this->load_dictionary($dict_file);
                } else {
                    $dict_item = str_replace(chr(9), " ", $dict_item);  // convert tab to space
                    while (strpos($dict_item, "  ")) {  // remove double spaces
                        $dict_item = str_replace("  ", " ", $dict_item);
                    }
                    $dict_item_e = explode(" ", $dict_item);    // split by space
                    switch ($dict_item_e[0]) {
                        case "VENDOR":
                            //$this->vendorRadiusAttributes[$dict_item_e[1]]["id"] = $dict_item_e[2];
                            //$this->log("VENDOR" . $dict_item_e[2]);
                            $current_vendorId = $dict_item_e[2];
                            break;
                        case "BEGIN-VENDOR":
                            $current_vendor = $dict_item_e[1];
                            break;
                        case "END-VENDOR":
                            $current_vendorId = NULL;
                            $current_vendor = NULL;
                            break;
                        case "ATTRIBUTE":
                            if (!$current_vendor) {                                
                                $this->log("None Vendor: " . $dict_item_e[2] ."=" . $dict_item_e[1]);
                            } else {                                
                                $this->vendorRadiusAttributes[$current_vendorId][$dict_item_e[2]] = array($dict_item_e[1], $this->radiusFormat[$dict_item_e[3]] ?? 'X');
                                $this->vendorReverseAttributes[$dict_item_e[1]] = [$current_vendorId, $dict_item_e[2]];                                
                            }
                            break;
                        case "VALUE":
                            break;
                        default:
                    }
                }
            }
            return true;
        } else {
            $this->log("Failed to load " . $file);
            return false;
        }
    }

    public function verifyChap(string $bin, string $pwd, string $chap)
    {
        if (strlen($bin) != 17) return false;
        $chapid = $bin[0];
        $string = substr($bin, 1);
        return md5($chapid . $pwd . $chap, true) == $string;
    }

    function decodePap(string $bin, string $Authenticator, string $secret)
    {
        $passwd = '';
        $S = $secret;
        $len = strlen($bin);
        $hash_b = md5($S . $Authenticator, true);
        for ($offset = 0; $offset < $len; $offset += 16) {
            for ($i = 0; $i < 16; $i++) {
                $pi = ord($bin[$offset + $i]);
                $bi = ord($hash_b[$i]);
                $chr = chr($pi ^ $bi);
                if ($chr == "\x0") {
                    return $passwd;
                }
                $passwd .= $chr;
            }
            if ($len == $offset + 16) {
                return $passwd;
            }
            $hash_b = md5($S . substr($bin, $offset, 16), true);
        }
        return '';
    }

    public function on($eventName, callable $callback)
    {
        if($eventName == "access-request") {
            $this->log("Access-Request Set");
            $this->requestAccess = $callback;
        } elseif($eventName == "accounting-start") {
            $this->log("Access-Start Set");
            $this->acctStart = $callback;
        } elseif($eventName == "accounting-stop") {
            $this->log("Access-Stop Set");
            $this->acctStop = $callback;
        } elseif($eventName == "accounting-interim") {
            $this->log("Access-Interim Set");
            $this->acctInterim = $callback;
        } else {
            $this->log("$eventName is not an Event!");
        }
    }

    function readyPacket($attributes)
    {
        

        $attributesToSend = [];
    
        foreach($attributes as $key => $val) {

            if(isset($this->reverseAttributes[$key])) {
                $code = $this->reverseAttributes[$key];
                $attributesToSend[] = [ $code => $this->encodeAttribute($val, $code)];
            } elseif(isset($this->vendorReverseAttributes[$key])) {
                $vendorId   =   $this->vendorReverseAttributes[$key][0];
                $code       =   $this->vendorReverseAttributes[$key][1];
                $format     =   $this->vendorRadiusAttributes[$vendorId][$code][1];
                $attributesToSend[] = [ 26 => $this->encodeVendorSpecific($vendorId, $code, $this->encodeAttributeFormat($val,$format)) ];
            } elseif($key === 'Mendyfi-Secret') {
            } else {
                $this->log("[WARNING]: Unkown \"$key\"");
            }
        }
        return $attributesToSend;
    }

    function processRadiusPacket(SocketServer $server, $data, $clientInfo)
    {
        $clientAttributes = [];

        $radiusData = $this->decodePackets($data, $clientAttributes);
        $radiusResponse = [
            'Reply-Message' => 'No Action Given'
        ];

        $accessResponse = 3;

        $accountingResponse = 5;

        $dynamicSecret = null;

        switch($radiusData['code']) {

            case 1:
                if (is_callable($this->requestAccess)) {
                    $this->log("Access-Request Recieved");
                    [$accessResponse , $radiusResponse, &$dynamicSecret] = call_user_func($this->requestAccess, $clientAttributes, $radiusData['authenticator']);                    
                } else {
                    $this->log("access-request is not defined");
                }

                $server->sendto($clientInfo['address'], $clientInfo['port'],
                    $this->encodePackets($dynamicSecret ?? $this->radiusSecret, $accessResponse, $radiusData['identifier'], $radiusData['authenticator'], $this->readyPacket($radiusResponse)), $clientInfo['server_socket']
                );
                break;
            case 4:
                if(isset($clientAttributes['Acct-Status-Type'])) {
                    switch($clientAttributes['Acct-Status-Type']) {
                        case "Start":
                            if (is_callable($this->acctStart)) {
                                $this->log("Accounting Start Recieved");
                                [$accountingResponse , $radiusResponse, &$dynamicSecret] = call_user_func($this->acctStart, $clientAttributes);                    
                            } else {
                                $this->log("accounting-start is not defined");
                            }
                            break;
                        
                            case "Stop":
                                if (is_callable($this->acctStop)) {
                                    $this->log("Accounting Stop Recieved");
                                    [$accountingResponse , $radiusResponse, &$dynamicSecret] = call_user_func($this->acctStop, $clientAttributes);                    
                                } else {
                                    $this->log("accounting-stop is not defined");
                                }
                                break;

                            case "Interim-Update":
                                if (is_callable($this->acctInterim)) {
                                    $this->log("Accounting Interim Recieved");
                                    [$accountingResponse , $radiusResponse, &$dynamicSecret] = call_user_func($this->acctInterim, $clientAttributes);                    
                                } else {
                                    $this->log("accounting-interim is not defined");
                                }
                                break;
                                
                    }
                } else {
                    $this->log('Unkown Request');
                }

                $server->sendto($clientInfo['address'], $clientInfo['port'],
                    $this->encodePackets($dynamicSecret ?? $this->radiusSecret, $accountingResponse, $radiusData['identifier'], $radiusData['authenticator'], $this->readyPacket($radiusResponse)), $clientInfo['server_socket']
                );
                break;
        }
    }

    public function run()
    {

        if(getenv('SWOOLE') == 'true') {        

            $server = new Swoole\Server($this->radiusIp, $this->radiusAuthPort, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);
            $server->set([
                'trace_flags' => 0
            ]);
            $server->addListener($this->radiusIp, $this->radiusAcctPort,SWOOLE_SOCK_UDP);
            $server->on('Packet', array($this, 'processRadiusPacket'));

            $server->start();
        } else {

            $server = new SocketServer();

            $server->addListener($this->radiusIp, $this->radiusAuthPort);
            $server->addListener($this->radiusIp, $this->radiusAcctPort);

            $server->on('Packet', array($this, 'processRadiusPacket'));

            $server->run();
        }
    }

}