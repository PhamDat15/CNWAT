<?php

namespace App\Models;

/**
 * Model Contact: Quản lý thông tin liên hệ danh bạ
 */
class Contact
{
    protected string $table = 'contacts';
    protected array $fillable = [
        'name', 'phone', 'email', 'address', 'category', 'birthdate', 'notes', 'avatar'
    ];

    public static function getCategories(): array {
        return [
            'Gia đình',
            'Bạn bè',
            'Công việc',
            'Khách hàng',
            'Đối tác',
            'Khác'
        ];
    }
}
