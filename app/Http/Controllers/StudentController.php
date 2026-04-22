<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // 1. GET List all student
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'status' => 'Success',
            'message' => 'Data semua student berhasil diambil',
            'data' => $students
        ], 200);
    }

    // 2. POST Create a student
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'nim' => 'required|string|unique:students',
            'email' => 'required|email|unique:students'
        ]);

        // Skenario: Failed (Validasi gagal)
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal menambahkan student, periksa inputan Anda',
                'errors' => $validator->errors()
            ], 400);
        }

        // Skenario: Success
        $student = Student::create($request->all());
        return response()->json([
            'status' => 'Success',
            'message' => 'Student berhasil ditambahkan',
            'data' => $student
        ], 201);
    }

    // 3. GET Get student by ID
    public function show($id)
    {
        $student = Student::find($id);

        // Skenario: Not found
        if (!$student) {
            return response()->json([
                'status' => 'Not found',
                'message' => 'Student tidak ditemukan'
            ], 404);
        }

        // Skenario: Success
        return response()->json([
            'status' => 'Success',
            'data' => $student
        ], 200);
    }

    // 4. PUT Edit a student
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 'Not found',
                'message' => 'Student tidak ditemukan'
            ], 404);
        }

        $student->update($request->all());

        return response()->json([
            'status' => 'Success',
            'message' => 'Data student berhasil diupdate',
            'data' => $student
        ], 200);
    }

    // 5. DEL Delete a student
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 'Not found',
                'message' => 'Student tidak ditemukan'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Data student berhasil dihapus'
        ], 200);
    }
}
