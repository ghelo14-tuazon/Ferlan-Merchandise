<!-- resources/views/staff/inquiries.blade.php -->
<style>
    .thead-blue {
        background-color: #1c294e;
        color: #fff;
    }
</style>
@extends('staff.layout.master')

@section('content')
    <div class="container mt-4">
        <h2>Staff Inquiries</h2>

        <table class="table">
            <thead class="thead-blue">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Staff Reply</th>
                    <th>Action</th> <!-- New column for delete button -->
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $inquiry)
                    <tr>
                        <td>{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->message }}</td>
                        <td>
                            @if($inquiry->staff_reply)
                                {{ $inquiry->staff_reply }}
                            @else
                                <form action="{{ route('staff.inquiry.reply', $inquiry->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form-control" name="staff-reply" rows="4"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Submit Reply</button>
                                </form>
                            @endif
                        </td>
                     <td>
    <form action="{{ route('staff.inquiry.delete', $inquiry->id) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i> <!-- Font Awesome trash icon -->
        </button>
    </form>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
