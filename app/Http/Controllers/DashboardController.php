<?php

  namespace App\Http\Controllers;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;

  class DashboardController extends Controller
  {
      public function index()
      {
            $reservations = $this->getReservations() ?? [];
            $products = $this->getProducts() ?? [];

            return view('index', [
                'title' => 'Dashboard Admin',
                'description' => 'Halaman utama untuk admin',
                'reservations' => $reservations,
                'countReservations' => count($reservations),
                'countTotalReservation' => $this->countTotalReservation(),
                'countTotalReservationPerMonth' => $this->countTotalReservationPerMonth(),
                'percentTotalReservationPerMonth' => $this->percentTotalReservationPerMonth(),
                'products' => $products,
                'countProducts' => count($products),
            ]);
      }

        // ================ Area Function Reservations ================
        // get reservations
        private function getReservations(){
            $reservations = FetchAPI(env('URL_API') . "/api/v1/reservations");
            return $reservations;
        }
        // Count reservation perMonth
        private function countTotalReservationPerMonth(){
            $reservations = $this->getReservations() ?? [];
            $changePercentPerMonth = [];
            foreach($reservations as $reservation){
                $month = date('m', strtotime($reservation['created_at']));
                if(!isset($changePercentPerMonth[$month])){
                    $changePercentPerMonth[$month] = 0;
                }
                $changePercentPerMonth[$month] += $reservation['total'];
            }
            return $changePercentPerMonth;
        }
        // Count reservation perMonth
        private function percentTotalReservationPerMonth(){
            $reservations = $this->getReservations() ?? [];
            $lastMonth = (int) date('m') - 1;
            $lastMonthTotal = 0;
            $currentMonthTotal = 0;

            foreach($reservations as $reservation){
                $month = (int) date('m', strtotime($reservation['created_at']));
                if($month == $lastMonth){
                    $lastMonthTotal += $reservation['total'];
                }
                if($month == (int) date('m')){
                    $currentMonthTotal += $reservation['total'];
                }
            }

            $percent = 0;
            if($lastMonthTotal > 0){
                $percent = ($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal * 100;
            }

            return $percent;
        }
        // count all reservation total
        private function countTotalReservation(){
            $reservations = $this->getReservations() ?? [];
            $total = 0;
            foreach($reservations as $reservation){
                $total += $reservation['total'];
            }
            return $total;
        }
        // ================ End Area Function Reservations ================

        // ================ Area Function Products ================
        // get products
        private function getProducts(){
            $products = FetchAPI(env('URL_API') . "/api/v1/products");
            return $products;
        }
        // ================ End Area Function Products ================
  }