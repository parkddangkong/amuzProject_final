<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars'; // 기본적으로 Car 모델은 'cars' 테이블을 참조하지만, 다른 이름으로 변경하려면 여기서 정의합니다.

    protected $fillable = ['brand', 'model', 'year', 'color']; // 대량 할당을 허용할 필드

    // 차량의 브랜드를 대문자로 반환하는 접근자
    public function getBrandAttribute($value)
    {
        return strtoupper($value);
    }

    // 차량 모델을 저장하기 전에 첫 글자를 대문자로 변경하는 변경자
    public function setModelAttribute($value)
    {
        $this->attributes['model'] = ucfirst($value);
    }

    // 차량과 관련된 다른 모델(예: Owner)과의 관계를 정의할 수 있습니다.
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    // 차량에 대한 예약 가져오기
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
