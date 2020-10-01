@extends('admin/include/master')
@section('title') لوحة التحكم | الاعلانات المميزة @endsection
@section('content')
<?php
use Carbon\Carbon;
?>

<section class="content"> 
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">كل الاعلانات المميزة</h3>
              </div>
                <div class="table-responsive box-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="text-align:center;"> اسم الاعلان </th>
                                <th style="text-align:center;">التصنيف</th>
                                <th style="text-align:center;">صاحب الاعلان</th>
                                <th style="text-align:center;">التعليقات</th>
                                <th style="text-align:center;">التقييمات</th>
                                <th style="text-align:center;">تمييز الاعلان</th>
                                <th style="text-align:center;">مشاهدة</th>
                                <th style="text-align:center;"> تعطيل </th>
                                <th style="text-align:center;"> تعديل </th>
                                <th style="text-align:center;"> حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($specialads  as $ad)
                        <?php 
                            $catname = DB::table('categories')->where('id',$ad->category)->value('name'); 
                            $adowner = DB::table('members')->where('id',$ad->user_id)->value('username');
                            $nowdate    = date("Y-m-d");
                            $enddate  = Carbon::parse(date("Y-m-d",strtotime($ad->end_date)));
                        ?>
                        
                            <tr>
                                <td>{{$ad->title}} </td>
                                <td>{{$catname}} </td>
                                <td> <a href="{{asset('adminpanel/users/'.$ad->user_id)}}"> {{$adowner}}</a></td>
                                <td>
                                    <a href='{{asset("adminpanel/adcomments/".$ad->id)}}' class="btn btn-default"> عرض التعليقات <i class="fa fa-comment bg-yellow" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    <a href='{{asset("adminpanel/adrates/".$ad->id)}}' class="btn btn-default"> عرض التقييمات <i class="fa fa-star bg-yellow" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                @if($nowdate < $enddate )
                                  <span style="border-radius: 3px;border: 1px solid #9EAB1C;color: #9EAB1C;padding: 3px;font-weight: bold;background: #fff;display: inline-block;float: left;margin-top: 4%;" 
                                   class="ads__item__featured">إعلان مميز </span>
                                @else
                                    {{ Form::open(array('method' => 'patch',"onclick"=>"return confirm('هل انت متاكد ؟!')",'files' => true,'url' =>'adminpanel/ads/'.$ad->id )) }}
                                        <input type="hidden" name="specialad" >
                                        <button type="submit" class="btn btn-default btn-block">
                                            <i style="color:#1FAB89" class="fa fa-check" aria-hidden="true"></i> 
                                        </button>
                                    {!! Form::close() !!}
                                @endif    
                                </td>
                                 <td>
                                    <a href='{{asset("adminpanel/ads/".$ad->id)}}' class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                {{ Form::open(array('method' => 'patch',"onclick"=>"return confirm('هل انت متاكد ؟!')",'files' => true,'url' =>'adminpanel/ads/'.$ad->id )) }}
                                    <input type="hidden" name="suspensed" >
                                    <button type="submit" class="btn btn-default">
                                    @if($ad->suspensed == 1) 
                                    <i style="color:crimson" class="fa fa-lock" aria-hidden="true"></i> 
                                    @else 
                                    <i style="color:#1FAB89" class="fa fa-unlock" aria-hidden="true"></i> 
                                    @endif
                                    </button>
                                {!! Form::close() !!}
                                </td>
                                <td>
                                    <a href='{{asset("adminpanel/ads/".$ad->id."/edit")}}' class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </td>

                                <td>
                                    {{ Form::open(array('method' => 'DELETE','id' => 'del'.$ad->id,"onclick"=>"return confirm('هل انت متأكد ؟!')",'files' => true,'url' => array('adminpanel/ads/'.$ad->id))) }}
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            
                        @endforeach
                        </tbody>
                    </table>
                </div>       
            </div>      
        </div>
    </div>
     
</section>
@endsection
