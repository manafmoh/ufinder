<?php

use App\User;
use Illuminate\Database\Seeder;
use App\Model\Category;
use App\Model\Ad;
use App\Model\Message;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //factory(User::class, 10)->create();
        //factory(Category::class, 5)->create();
        //factory(Ad::class, 10)->create();
        factory(Message::class, 10)->create()->each(
            function($message){
                return $message->like()->save(factory(User::class)->make());
            }
        );
    }
}
