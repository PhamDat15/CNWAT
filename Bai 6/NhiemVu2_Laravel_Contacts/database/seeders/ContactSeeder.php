<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'name' => 'TS. Nguyễn Văn Hùng',
                'phone' => '0912345678',
                'email' => 'hungnv@kma.edu.vn',
                'address' => 'Khoa An Toàn Thông Tin, KMA',
                'category' => 'Công việc',
                'birthdate' => '1982-05-15',
                'notes' => 'Giảng viên hướng dẫn môn học Công nghệ Web An Toàn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phạm Tiến Đạt',
                'phone' => '0988776655',
                'email' => 'datpt@kma.edu.vn',
                'address' => 'Hà Nội, Việt Nam',
                'category' => 'Gia đình',
                'birthdate' => '2004-10-20',
                'notes' => 'Sinh viên AT200311 - Lớp AT20A.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trần Hoàng Minh',
                'phone' => '0978123456',
                'email' => 'minhth@gmail.com',
                'address' => '141 Chiến Thắng, Tân Triều, Thanh Trì, Hà Nội',
                'category' => 'Bạn bè',
                'birthdate' => '2004-03-12',
                'notes' => 'Bạn cùng lớp AT20A.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
