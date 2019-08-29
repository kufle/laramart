<?php

use Illuminate\Database\Seeder;

class UsersdataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User;
        $user->name = "Irawan";
        $user->email = "irawan@kasep.com";
        $user->level = json_encode(["ADMIN"]);
        $user->password = \Hash::make("irawan");
        $user->avatar = "belum-punya.jpg";

        $user->save();

        $user2 = new \App\User;
        $user2->name = "Irawan Deui";
        $user2->email = "irawandeui@kasep.com";
        $user2->level = json_encode(["STAFF"]);
        $user2->password = \Hash::make("irawan");
        $user2->avatar = "belum-punya.jpg";

        $user2->save();

        $this->command->info("berhasil insert users");
    }
}
