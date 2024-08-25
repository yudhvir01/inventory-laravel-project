<!-- resources/views/assign-details.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: right;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
            height: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        */ .details {
            margin-bottom: 20px;
        }

        .signature-section {
            margin-top: 30px;
        }

        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Undertaking Form</h1>
    {{-- <div class='header'>
        <img src={{public_path('/logos/Atulaya_Logo-851.svg')}} alt="Logo">
    </div> --}}

    <div class='details'>
        <h2>Asset Details:</h2>
        <table>
            <tr>
                <th>UID</th>
                <td>{{ $assign->assignable->uid }}</td>
            </tr>
            @if ($assign->company->name == 'Atulaya Healthcare')
            {{ $company = 'ATL' }}
            {{$part1=substr($assign->assignable->uid, 0, 4);}}

            {{$lastThreeWords = substr($assign->assignable->uid, -3);}}
             {{ $cleanString = str_replace('-', '', $company.$lastThreeWords.$part1) }}
            <tr>
                <th>Host Name</th>
                <td>{{ $cleanString  }}</td>
            </tr>
        @endif

            <tr>
                <th>Manufacturer</th>
                <td>{{ $assign->assignable->manufacturer->name }}</td>
            </tr>
            @isset($assign->assignable->processor->name)
                <tr>
                    <th>Processor</th>
                    <td>{{ $assign->assignable->processor->name }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->version->name)
                <tr>
                    <th>Model</th>
                    <td>{{ $assign->assignable->version->name }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->system_serial_number)
                <tr>
                    <th>Serial Number</th>
                    <td>{{ $assign->assignable->system_serial_number }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->ram)
                <tr>
                    <th>RAM</th>
                    <td>{{ $assign->assignable->ram }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->memory_size)
                <tr>
                    <th>Hard Disk</th>
                    <td>{{ $assign->assignable->memory_size }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->keyboard)
                <tr>
                    <th>Keyboard</th>
                    <td>{{ $assign->assignable->keyboard ? 'Yes' : 'No' }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->mouse)
                <tr>
                    <th>Mouse</th>
                    <td>{{ $assign->assignable->mouse ? 'Yes' : 'No' }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->model)
                <tr>
                    <th>Model</th>
                    <td>{{ $assign->assignable->model }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->imei_number )
                <tr>
                    <th>IMEI Number</th>
                    <td>{{ $assign->assignable->imei_number }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->extension_number)
                <tr>
                    <th>Extension Number</th>
                    <td>{{ $assign->assignable->extension_number }}</td>
                </tr>
            @endisset
            @isset($assign->assignable->keyboard)
                <tr>
                    <th>
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Original Bag
                        </label>
                    </th>
                    <td>
                        &nbsp;&nbsp;<div style="display: inline"><input id="default-checkbox" type="checkbox" value="Yes"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">Yes</input>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div style="display: inline "><input id="default-checkbox" type="checkbox" value="Yes"
                                class="w-4  h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">No</input>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Original Charger
                        </label>
                    </th>
                    <td>

                        &nbsp;&nbsp;<div style="display: inline"><input id="default-checkbox" type="checkbox" value="Yes"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">Yes</input>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div style="display: inline "><input id="default-checkbox" type="checkbox" value="Yes"
                                class="w-4  h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">No</input>
                        </div>
                    </td>
                </tr>
            @endisset

            <tr>

                <th>Remarks</th>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="flex items-center mb-4">

    </div>
    <p>
        Above Mentioned Equipment items are issued to:-<br>
        <i> <span style="color: red;">*</span> The event of any damage, the employee may be held accountable for the
            costs associated with repairs or replacement</i>
    </p>
    <div class='signature-section'>
        <p><strong>Name of Employee:</strong> {{ $assign->user->name }}</p>
        <p><strong>Company:</strong>{{ $assign->company->name }}</p>
        <p><strong>Branch:</strong> {{ $assign->branch->name }}</p>
        <p><strong>Department:</strong> {{ $assign->department->name }}</p>
        <p><strong>Signature:</strong> <span class='signature-line'></span></p>
        <p><strong>Date:</strong> {{ $assign->assigned_at->format('d/m/Y') }}</p>
    </div>
    <div class='signature-section'>
        <p><strong>Received from:</strong> {{ $currentUser->name }}</p>
        <p><strong>Signature:</strong> <span class='signature-line'></span></p>
        <p><strong>Date:</strong> {{ now()->format('d/m/Y') }}</p>
    </div>
    <p><i>It is being issued for official purpose only.</i></p>


    {{-- //<a href="{{ route('download.assign.details.pdf', ['id' => $assign->id]) }}" class="download-btn">Download PDF</a> --}}
</body>

</html>
