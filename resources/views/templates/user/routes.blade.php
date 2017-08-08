
/* Auto-generated admin routes */
{!! str_pad("Route::get('/admin/".$modelViewsDirectory."',", 60) !!}'{{ $controllerPartiallyFullName }}@index');
{!! str_pad("Route::get('/admin/".$modelViewsDirectory."/create',", 60) !!}'{{ $controllerPartiallyFullName }}@create');
{!! str_pad("Route::post('/admin/".$modelViewsDirectory."/store',", 60) !!}'{{ $controllerPartiallyFullName }}@store');
{!! str_pad("Route::get('/admin/".$modelViewsDirectory."/edit/{".$modelVariableName."}',", 60) !!}'{{ $controllerPartiallyFullName }}@edit')->name('admin/{{ $modelViewsDirectory }}/edit');
{!! str_pad("Route::post('/admin/".$modelViewsDirectory."/update/{".$modelVariableName."}',", 60) !!}'{{ $controllerPartiallyFullName }}@update')->name('admin/{{ $modelViewsDirectory }}/update');
{!! str_pad("Route::delete('/admin/".$modelViewsDirectory."/destroy/{".$modelVariableName."}',", 60) !!}'{{ $controllerPartiallyFullName }}@destroy')->name('admin/{{ $modelViewsDirectory }}/destroy');
{!! str_pad("Route::get('/admin/".$modelViewsDirectory."/resend-activation/{".$modelVariableName."}',", 60) !!}'{{ $controllerPartiallyFullName }}@resendActivationEmail')->name('admin/{{ $modelViewsDirectory }}/resendActivationEmail');