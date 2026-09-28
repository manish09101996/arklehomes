<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f5f0; margin: 0; padding: 20px; color: #111f27; }
        .card { background-color: #ffffff; max-width: 600px; margin: 0 auto; border-radius: 8px; overflow: hidden; border: 1px solid #e5dfd5; }
        .header { background-color: #0c1b23; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 1px; }
        .header p { color: #e5a93c; margin: 5px 0 0 0; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; }
        .body { padding: 30px; }
        .field { margin-bottom: 20px; }
        .field-label { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #718096; font-weight: 600; margin-bottom: 4px; }
        .field-val { font-size: 16px; color: #0c1b23; font-weight: 500; }
        .message-box { background-color: #fcfbf9; border-left: 3px solid #e5a93c; padding: 15px; border-radius: 4px; font-size: 15px; line-height: 1.6; }
        .footer { background-color: #f5efe6; padding: 20px; text-align: center; font-size: 13px; color: #64748b; }
        .btn { display: inline-block; background-color: #e5a93c; color: #0c1b23; font-weight: 700; text-decoration: none; padding: 12px 25px; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>ARKLE HOMES</h1>
            <p>New Website Project Enquiry</p>
        </div>
        <div class="body">
            <div class="field">
                <div class="field-label">Client Name</div>
                <div class="field-val">{{ $enquiry->name }}</div>
            </div>
            <div class="field">
                <div class="field-label">Email Address</div>
                <div class="field-val"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></div>
            </div>
            <div class="field">
                <div class="field-label">Phone</div>
                <div class="field-val">{{ $enquiry->phone ?? 'Not provided' }}</div>
            </div>
            <div class="field">
                <div class="field-label">Project Type</div>
                <div class="field-val">{{ $enquiry->project_type ?? 'General Enquiry' }}</div>
            </div>
            <div class="field">
                <div class="field-label">Message Details</div>
                <div class="message-box">
                    {!! nl2br(e($enquiry->message)) !!}
                </div>
            </div>
            <div style="text-align: center;">
                <a href="{{ url('/admin/enquiries/' . $enquiry->id) }}" class="btn">View in Admin Dashboard</a>
            </div>
        </div>
        <div class="footer">
            Received via Arkle Homes website • {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>
</body>
</html>
