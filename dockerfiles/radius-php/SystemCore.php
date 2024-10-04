<?php

/**
 * Source: https://github.com/CodFrm/php-radius
 */

class SystemCore
{
    var $sys_msg = [];

    public function getCpuRealTimeUse(): int {
        static $record = ['all' => 0, 3 => 0];
        $stat = file_get_contents("/proc/stat");
        if (preg_match('/cpu\s{0,}(.*?)[\r\n]/', $stat, $match)) {
            $info = explode(' ', $match[1]);
            $all = $info[0] + $info[1] + $info[2] + $info[3] + $info[4] + $info[5] + $info[6];
            $ret = ($all - $record['all'] - ($info[3] - $record[3])) / ($all - $record['all']) * 100;
            $record = $info;
            $record['all'] = $all;
            var_dump($ret);
            if ($ret <= 0)
                return 0;
            return $ret;
        }
        return 0;
    }

    public function getSysLoad(): array {
        $info = file_get_contents("/proc/loadavg");
        return explode(' ', $info);
    }

    public function getCpuInfo(): array {
        $ret = [];
        $info = file_get_contents('/proc/cpuinfo');
        if (preg_match_all('/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(\@.-]+)([\r\n]+)/', $info, $matches)) {
            $ret['model'] = $matches[1][0];
            $ret['num'] = count($matches[1]);
        }
        return $ret;
    }

    public function getNetworkInfo(): array {
        $ret = [];
        $info = file_get_contents('/proc/net/dev');
        preg_match_all('/(\w+):(.*?)[\r\n]/', $info, $match);
        foreach ($match[1] as $key => $val) {
            preg_match_all('/(\d+)\s{0,}/', $match[2][$key], $sub_match);
            $ret[$val]['out'] = intval($sub_match[1][8]);
            $ret[$val]['in'] = intval($sub_match[1][0]);
        }
        return $ret;
    }

    public function getMemInfo(): array {
        $ret = ['total' => 0, 'free' => 0];
        $info = file_get_contents('/proc/meminfo');
        if (preg_match('/MemTotal:\s{0,}(\d+)\s{0,}.*?[\r\n]+/', $info, $matches)) {
            $ret['total'] = intval($matches[1]);
        }
        if (preg_match('/MemFree:\s{0,}(\d+)\s{0,}.*?[\r\n]+/', $info, $matches)) {
            $ret['free'] = intval($matches[1]);
        }
        $ret['use'] = $ret['total'] - $ret['free'];
        return $ret;
    }

    public function getDiskInfo(): array {
        $ret = [];
        $ret['total'] = disk_total_space('.');
        $ret['use'] = $ret['total'] - disk_free_space('.');
        return $ret;
    }

    function getServerInfo(): array {
        $ret = $this->sys_msg;
        $ret['cpu']['use'] = $this->getCpuRealTimeUse();
        $ret['disk'] = $this->getDiskInfo();
        $ret['mem'] = $this->getMemInfo();
        $ret['network'] = $this->getNetworkInfo();
        $ret['load'] = $this->getSysLoad();
        $ret['time'] = time();
        return $ret;
    }

    function __construct() {
        $this->sys_msg['cpu'] = $this->getCpuInfo();
        $this->sys_msg['mem'] = $this->getMemInfo();
        $this->getCpuRealTimeUse();
    }
}