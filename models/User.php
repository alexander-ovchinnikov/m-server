<?php
    class User {
        private $user_id;
        private $nick;      
        private $DB;

        # common function
        #
        public function create(string $device_id) : self  {
            Adapter::insert(
                ['device_id'=>$device_id]
            );
            self::load(
                Adapter::get(['device_id'=>$device_id])
            );

            return $this;            
        }

        #public function g
        public function load( array $data) : self {
            $item = new self();

            foreach ($data as $key => $value) {
                if (!property_exists(self,$key)) {
                    // exception. no field exists
                }
                $item[$key] = $value;
            }
            return $item;
        }

        public function getAccounts() {

        }
    }
?>
