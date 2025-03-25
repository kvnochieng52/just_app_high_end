<p>Hello {{ $created_by_name }}, </p>
<p>Property: {{ $property_title}} has been {{$action == 'approve' ? " APPROVED" : " DECLINED"}}</p>
<p>Comment: {{$comment}}</p>
<p>If you think this is a mistake please contact us through: info@justhomes.co.ke</p>