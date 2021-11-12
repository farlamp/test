<?php

class Tool
{
    /**
     * @param $start string (Origin)
     * @param $end string (Destination)
     * @param $type int (Type)
     */
    public function index($start, $end, $type)
    {
        include_once 'Predis.php';
        if (empty($start) || empty($end) || empty($type)) {
            return [];
        }
        $data = Predis::getInstance()->get('list');
        $data = json_decode($data, true);
        if (empty($data)) {
            $data = [];
        }
        /**
         * train_number (Flight Number / Train Number)
         * type (Transport mode : 1. Train  2. Bus  3. Airplane 4. Boat  5. high speed railway / bullet train ) This option is expandable for more transport mode.
         * seat (Seat Number)
         * boarding_gate (Boarding Gate)
         * desc (Description)
         * start (Origin)
         * end (Destination)
         * sort (Sort in Ascending Order)
         */
        $datas = [
            ['train_number' => '78A', 'type' => '1', 'seat' => '45B', 'boarding_gate' => '', 'desc' => '', 'start' => 'Madrid', 'end' => 'Barcelona', 'sort' => '1'],
            ['train_number' => '', 'type' => '2', 'seat' => '', 'boarding_gate' => '', 'desc' => '', 'start' => 'Barcelona', 'end' => 'Geron Airport', 'sort' => '2'],
            ['train_number' => 'SK455', 'type' => '3', 'seat' => '3A', 'boarding_gate' => '45B', 'desc' => 'Baggage drop at ticket coumter 344', 'start' => 'Geron Airport', 'end' => 'Stockholm', 'sort' => '3'],
            ['train_number' => 'SK22', 'type' => '3', 'seat' => '7B', 'boarding_gate' => '22', 'desc' => 'Baggage will we automatically transferred from your last leg', 'start' => 'Stockholm', 'end' => 'New York JFK', 'sort' => '4'],
        ];
        foreach ($datas as $item) {
            if ($item['start'] == $start && $end == $item['end'] && $type == $item['type']) {
                $data[$start . $end . $type] = $item;
            }
        }
        Predis::getInstance()->set('list', json_encode($data));
        $data = array_values($data);
        return $this->arraySort($data, 'sort');
    }

    /**
     * Two-dimensional array sorting
     * @param $array array (Sorted Array)
     * @param $keys string (Sorted Value)
     * @param string $sort asc (Ascending Order)  desc (Decending Order)
     * @return array
     */
    private function arraySort($array, $keys, $sort = 'asc')
    {
        $newArr = $valArr = array();
        foreach ($array as $key => $value) {
            $valArr[$key] = $value[$keys];
        }
        ($sort == 'asc') ? asort($valArr) : arsort($valArr);
        reset($valArr);
        foreach ($valArr as $key => $value) {
            $newArr[$key] = $array[$key];
        }
        return $newArr;
    }
}