<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePackageUser extends Model
{
    protected $connection = 'mysql_kedua';

    protected $table = 'course_package_user';

    protected $fillable = ['course_package_id', 'username', 'password', 'payment_status', 'user_id', 'learning_methode', 'status'];
}