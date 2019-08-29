<?php

use Illuminate\Database\Seeder;

class SettingdataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new \App\Setting;
        $setting->nama_perusahaan = "Laramart";
        $setting->alamat = "Jl.jalan terus";
        $setting->telephone = "0123456789";
        $setting->logo = "belum-ada.jpg";
        $setting->kartu_member = "card_img.jpg";
        $setting->diskon_member = "10";
        $setting->tipe_nota = "0";

        $setting->save();

        $this->command->info("berhasil insert setting");
    }
}
