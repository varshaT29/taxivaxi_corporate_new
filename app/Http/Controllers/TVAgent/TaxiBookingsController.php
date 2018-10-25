<?php



namespace App\Http\Controllers\Operator;
use App\Company;
use App\Taxi_Bookings;
use App\Employee_Details;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mapper;

class TaxiBookingsController extends Controller
{

  public function create()
  {
    $companys = Company::all();

    $empdetails = Employee_Details::all();
    return view('operator.TaxiBookings.create',compact('companys','empdetails'));
  }

  public function showpassenger($id) {
    $empdets = Employee_Details::where('taxibookingid',$id)->get();
    return view('operator.TaxiBookings.PassengerDetails', compact('empdets'));

  }

  public function index()
  {
    $bookings = Taxi_Bookings::all();
    return view('operator.TaxiBookings.index',compact('bookings'));
  }

  public function submit(Request $request){

    $bookings = new Taxi_Bookings;
    $empdet = new Employee_Details;

    $bookings->taxibooking_companyname =$request->input('taxibooking_companyname');
    $bookings->tourtype =$request->input('tourtype');
    $bookings->pickup_location=$request->input('pickup_location');
    $bookings->drop_location = $request->input('drop_location');
    $bookings->bookingdatetime =$request->input('bookingdatetime');
    $bookings->pickupdatetime =$request->input('pickupdatetime');
    $bookings->assessmentcode =$request->input('assessmentcode');
    $bookings->billing_entity =$request->input('billing_entity');
    $bookings->reason_for_booking =$request->input('reason_for_booking');
    $bookings->send_sms =$request->input('send_sms');
    $bookings->send_email =$request->input('send_email');
    $bookings->spocname =$request->input('spocname');
    $bookings->no_of_seats=$request->input('no_of_seats');
    $bookings->save();
    $eid=$bookings->id;
    $no_of_seats_data = $bookings->no_of_seats;
    for($i=0;$i<$no_of_seats_data;$i++)
    {
            $data = array(
                            'taxibookingid'=>$eid,
                            'employeename'=>$request->employeename [$i],
                            'employeeid'=>$request->employeeid [$i],
                            'employeecontact'=>$request->employeecontact [$i],
                            'employeeemail'=>$request->employeeemail [$i],
                );
            Employee_Details::insert($data);
        }


    $bookings->save();
    return redirect()->route('operator.create-TaxiBookings');

  }



}
