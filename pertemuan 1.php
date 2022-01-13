<?php
    class Catalogue{
        //menginisialisasi 
        private function createProductColumn($columns, $listOfRawProducts){
            foreach(array_keys($listOfRawProducts) as $listOfRawProductKey){
                // change index name
                $listOfRawProducts[$columns[$listOfRawProductKey]] = $listOfRawProducts[$listOfRawProductKey];
                // clear list
                unset($listOfRawProducts[$listOfRawProductKey]);
            }
            return $listOfRawProducts;
        }
        //fungsi untuk mengindentifikasi nama file dan isi dari file tersebut
        function product($parameter){ //2
            $collectionOfListProducts = [];

            $raw_data = file($parameter['file_name']);
            
            // Split name and price index
            foreach($raw_data as $listOfRawProducts){ //3
                $collectionOfListProducts[] = $this->createProductColumn($parameter['columns'], explode(',', $listOfRawProducts));
            }

            return [
                'product' => $collectionOfListProducts,
                'gen_length' => count($collectionOfListProducts),
            ];
        }
    }

    class PopulationGenerator{
        // Generate random between 0 and 1 for each product
        private function createIndividu($parameter){
            $catalogue = new Catalogue;
            $gen_length = $catalogue->product($parameter)['gen_length']; 
            for($i=0; $i<$gen_length; $i++){
                $ret[] = rand(0, 1);
            }
            return $ret;
        }

        function createPopulation($parameter){ //3
            for($i=0; $i<$parameter['population_size']; $i++){
                $ret[] = $this->createIndividu($parameter);
            }
            foreach($ret as $key => $val){
                print_r($val);
                echo '<br>';
            }
        }
    }

    //parameter awal
    $parameter = [ //berbentuk array
        'file_name' => 'product.txt', //inisiasi agar file txt dapat digunakan
        'columns' => ['item', 'price'], // inisiasi nama produk dan harga agar dapat dicari di dalam file
        'population_size' => 10 //inisiasi jumlah individu yang akan dibuat
    ];

    //memanggil fungsi
    $initialPopulation = new PopulationGenerator;
    $initialPopulation->createPopulation($parameter);
?>