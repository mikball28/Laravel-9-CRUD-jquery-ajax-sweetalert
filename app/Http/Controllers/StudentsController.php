<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Json;

class StudentsController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);

        $studentData = [
            'name' => $request->fname,
            'surname' => $request->lname,
            'email' => $request->email,
            'number' => $request->number,
            'avatar' => $fileName
        ];

        Students::create($studentData);
        return response()->json([
            'status' => 200
        ]);

    }

    public function fetchall()
    {
        $student = Students::all();
        $output = '';
        if ($student->count() > 0) {
            $output .= '<table class="table table-striped table-sm  align-middle">
                <thead>
                    <tr>
                        <th class="scope">ID</th>
                        <th>Avatar</th>
                        <th>Ad</th>
                        <th>Soyad</th>
                        <th>Email</th>
                        <th>Numara</th>
                        <th>Durum</th>
                   
                    </tr>
                </thead>
                <tbody>';
            foreach ($student as $items) {
                $output .= '<tr>
                    <td><b>' . $items->id . '</b></td>
                    <td><img src="storage/images/' . $items->avatar . '" width="50" class="img-thumbnail rounded-circle"></td>
                    <td>' . $items->name . '</td>
                    <td>' . $items->surname . '</td>
                    <td>' . $items->email . '</td>
                    <td>' . $items->number . '</td>
                    <td>
                        <a href="#" id="' . $items->id . '" class="text-success mx-1 editIcon" 
                        data-bs-toggle="modal" data-bs-target="#editStudentModal"><i class="fa fa-refresh " style="font-size:20px"></i></a>
                        <a href="#" id="'.$items->id.'" class="text-danger ms-2 deleteIcon"><i class="fa fa-trash" style="font-size:22px"></i></a>
                    </td>

                    </tr>';
            }
            $output.='
                </tbody>
            </table>';
            echo $output;
            }
            else{
            echo '<h1 class="text-center text- secondary my-5">Kayıt Yok</h1>';
            }
    }

    public function edit(Request $request){
        $id = $request->id;
        $student = Students::find($id);
        return response()->json($student);

    }

    public function update(Request $request){
        $fileName = '';
        $student = Students::find($request->student_id);
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if($student->avatar){
                Storage::delete('public/images/' . $student->avatar);
            }
            else{
                $fileName = $request->student_avatar;
            }
            $studentData = [
                'name' => $request->fname,
                'surname' => $request->lname,
                'email' => $request->email,
                'number' => $request->number,
                'avatar' => $fileName

            ];
            $student->update($studentData);
            return response()->json([
                'status'=>200
            ]);

        }
    }

    public function delete(Request $request) {
		$id = $request->id;
		$student = Students::find($id);
		if (Storage::delete('public/images/' . $student->avatar)) {
			Students::destroy($id);
		}
	}

}
