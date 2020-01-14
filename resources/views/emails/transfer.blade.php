@extends('emails.container')

@section('content')

<table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
    <tr style="border-collapse:collapse;">
        <td align="center" style="padding:0;Margin:0;">
            <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;">
                <tr style="border-collapse:collapse;">
                    <td align="left" style="padding:0;Margin:0;padding-top:30px;padding-left:30px;padding-right:30px;">
                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                            <tr style="border-collapse:collapse;">
                                <td width="540" valign="top" align="center" style="padding:0;Margin:0;">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="left" style="padding:0;Margin:0;">
                                                <h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:tahoma, verdana, segoe, sans-serif;font-size:24px;font-style:normal;font-weight:normal;color:#333333;">
                                                    {{ $body_text_title }}<br></h2>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse;">
                                            <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:10px;">
                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'lucida sans unicode', 'lucida grande', sans-serif;line-height:21px;color:#666666;">
                                                    {{ $body_text_content }}<br></p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="border-collapse:collapse;">
                    <td align="left" style="padding:30px;Margin:0;">
                        <!--[if mso]><table width="540" cellpadding="0" cellspacing="0"><tr><td width="140"><![endif]-->
                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                            <tr style="border-collapse:collapse;">
                                <td class="es-m-p0r es-m-p20b" width="120" align="center" style="padding:0;Margin:0;">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;">
                                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                    <tr style="border-collapse:collapse;">
                                                        <td style="padding:0;Margin:0px;border-bottom:1px solid #FFFFFF;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="es-hidden" width="20" style="padding:0;Margin:0;"></td>
                            </tr>
                        </table>
                        <!--[if mso]></td><td width="140"><![endif]-->
                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                            <tr style="border-collapse:collapse;">
                                <td class="es-m-p20b" width="120" align="center" style="padding:0;Margin:0;">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="center" style="padding:0;Margin:0;"><span class="es-button-border" style="border-style:solid;border-color:#0077D6;background:#50B948 none repeat scroll 0% 0%;border-width:2px;display:block;border-radius:4px;width:auto;"><a href="{{ route('ad.edit', ['ad' => $ad]) }}" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;color:#FFFFFF;border-style:solid;border-color:#0077D6;border-width:10px 25px 10px 25px;display:block;background:#0077D6;border-radius:4px;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center;border-left-width:0px;border-right-width:0px;">Modificar</a></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="es-hidden" width="20" style="padding:0;Margin:0;"></td>
                            </tr>
                        </table>
                        <!--[if mso]></td><td width="120"><![endif]-->
                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                            <tr style="border-collapse:collapse;">
                                <td class="es-m-p20b" width="120" align="center" style="padding:0;Margin:0;">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="center" style="padding:0;Margin:0;"><span class="es-button-border" style="border-style:solid;border-color:#0077D6;background:#50B948 none repeat scroll 0% 0%;border-width:2px;display:block;border-radius:4px;width:auto;"><a href="{{ route('promote_ad', ['ad' => $ad]) }}" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;color:#FFFFFF;border-style:solid;border-color:#0077D6;border-width:10px 25px 10px 25px;display:block;background:#0077D6;border-radius:4px;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center;border-left-width:0px;border-right-width:0px;">Promocionar</a></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!--[if mso]></td><td width="20"></td><td width="120"><![endif]-->
                        <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;">
                            <tr style="border-collapse:collapse;">
                                <td width="120" align="center" style="padding:0;Margin:0;">
                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                        <tr style="border-collapse:collapse;">
                                            <td align="center" style="padding:0;Margin:0;padding-bottom:5px;padding-left:20px;padding-right:20px;">
                                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                    <tr style="border-collapse:collapse;">
                                                        <td style="padding:0;Margin:0px;border-bottom:1px solid #FFFFFF;background:rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height:1px;width:100%;margin:0px;">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!--[if mso]></td></tr></table><![endif]-->
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@endsection