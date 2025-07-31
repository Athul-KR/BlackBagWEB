@extends('frontend.master_website')
@section('title', 'Privacy Policy')
@section('content')
<style>
.wp-policy p{
    font-size: 15px !important;
  line-height: 23px !important;
    color: #333 !important; 
}
.wp-policy p a{
    color: #426d9b !important;
}
.wp-policy p a:hover{
     color: #333 !important;
}
.wp-policy ul li {
display: list-item !important;
font-size: 15px !important;
    line-height: 20px !important;
    color: #333 !important; 
}
.wp-policy ul{
  padding: revert !important;
  list-style: inherit !important;
}
.wp-policy h3{
  font-size: 26px !important;  
  margin-top: 20px;
}
.wp-policy h4{
    font-size: 19px !important;
    margin-top: 10px;
}
</style>
<section class="mt-5">
    <div class="container pt-5">
        <div class="row   justify-content-center">
            <div class="col-lg-8 cul-12">
                <div class="content_box   mb-lg-0 mb-4">
                <h3 class="mb-5 text-center">Privacy Policy</h3>

                <div class="wp-policy">
                    <div class="mb-3">
                        <p class="date mb-2"><strong>Effective Date:</strong> 01/01/2025</p>
                        <p class="date"><strong>Last Updated:</strong> 06/05/2025</p>
                    </div>  
                    <p class="mb-3">BlackBag ("Company," "we," "our," or "us") is committed to respecting and protecting the privacy and security of all users ("you," "your," or "User") who access or utilize our software, mobile applications, websites, and services (collectively, the "Platform"). This Privacy Policy outlines how information is collected, processed, stored, disclosed, and safeguarded when engaging with the Platform, in accordance with applicable laws and regulations, including but not limited to the Health Insurance Portability and Accountability Act (HIPAA), the General Data Protection Regulation (GDPR), and other relevant privacy frameworks.</p>
                    <p>By accessing or using the Platform, you acknowledge that you have read, understood, and agree to be bound by the terms set forth in this Privacy Policy.</p>   

                    <h3>1. Information We Collect</h3>
                    <p>We may collect and process various categories of information, which may include, but is not limited to, the following:</p>



                    <h4>a. Personal Identifiable Information (PII)</h4>
                    <p>This includes any data that can reasonably be used to identify you, such as:</p>
                    <ul>
                        <li>Full name</li>
                        <li>Email address</li>
                        <li>Telephone number</li>
                        <li>Job title and professional affiliation</li>
                        <li>Organization or clinic name</li>
                        <li>Billing and mailing address</li>
                        <li>Payment method and transaction details (processed securely by third-party providers)</li>
                    </ul>



                     <h4>b. Practice Information</h4>
                     <p>Includes operational details about your medical practice, which may include:</p>
                    <ul>
                        <li>Practice size and specialty areas</li>
                        <li>Number of clinicians and staff</li>
                        <li>Preferred service configurations and workflow customizations</li>
                        <li>Submitted data necessary for platform optimization</li>
                    </ul>



                     <h4>c. Protected Health Information (PHI)</h4>
                     <p>When utilizing BlackBag to store, transmit, or manage patient-related data, information that constitutes PHI under HIPAA may be collected, such as:</p>
                    <ul>
                        <li>Patient names, identifiers, and contact information</li>
                        <li>Clinical documentation and encounter notes</li>
                        <li>Medical histories, prescriptions, and diagnostic results</li>
                        <li>Communication records between patients and providers</li>
                    </ul>





                    <h4>d. Technical and Usage Data</h4>
                    <p>We may automatically collect data regarding your interactions with the Platform, such as:</p>
                    <ul>
                        <li>Internet Protocol (IP) address</li>
                        <li>Browser type and version</li>
                        <li>Device identifiers</li>
                        <li>Date/time stamps of access</li>
                        <li>Pages viewed and features used</li>
                        <li>Session duration and clickstream data</li>
                    </ul>





                    <h3>2. Use of Information</h3>
                    <p>Information collected through the Platform may be used for purposes including, but not limited to:</p>
                    <ul>
                        <li>Creating and managing user accounts and provider profiles</li>
                        <li>Delivering core software functionality and associated services</li>
                        <li>Providing technical support, maintenance, and customer service</li>
                        <li>Enhancing platform performance, usability, and reliability</li>
                        <li>Sending communications related to account activity, system updates, or new features</li>
                        <li>Processing billing transactions and issuing invoices</li>
                        <li>Facilitating legal and regulatory compliance, including HIPAA, GDPR, and other applicable laws</li>
                    </ul>


                    <h3>3. Data Security and Protection</h3>
                    <p>BlackBag employs a multi-layered approach to data security, including administrative, technical, and physical safeguards designed to protect your information from unauthorized access, loss, misuse, or alteration. Security practices include:</p>
                    <ul>
                        <li><strong>Encryption:</strong> All data is encrypted in transit (using TLS 1.2 or higher) and at rest using industry-standard protocols</li>
                        <li><strong>Access Controls:</strong> Role-based access restrictions and authentication protocols are enforced</li>
                        <li><strong>Audit Logging:</strong> Comprehensive activity logs are maintained to monitor access, detect anomalies, and investigate potential breaches</li>
                        <li><strong>Secure Infrastructure:</strong> Hosted in HIPAA-compliant, SOC 2 Type II-certified cloud environments with disaster recovery protocols in place</li>
                    </ul>
                     <p>Despite these measures, no system can guarantee absolute security. Users are encouraged to implement strong password practices and safeguard access credentials.</p>


                    
                    <h3>4. Disclosure and Sharing of Information</h3>
                    <p>BlackBag does not sell, rent, or lease personal or protected information to third parties. Disclosure may occur under the following limited circumstances:</p>
                    <ul>
                        <li><strong>Service Providers:</strong> Third-party vendors engaged for cloud hosting, data analytics, customer support, payment processing, or similar functions may have access to data under strict contractual obligations, including Business Associate Agreements (BAAs) where required</li>
                        <li><strong>Legal Compliance:</strong> Information may be disclosed in response to lawful requests by public authorities, including court orders, subpoenas, or regulatory obligations</li>
                        <li><strong>User-Directed Actions:</strong> Information may be disclosed to third-party systems or integrations only with explicit user authorization or consent</li>
                    </ul>

                                        
                    <h3>5. Data Subject Rights and User Choices</h3>
                    <p>Subject to applicable law, users have the right to:</p>
                    <ul>
                        <li><strong>Access</strong> personal and account-related data</li>
                        <li><strong>Rectify</strong> inaccuracies or incomplete information</li>
                        <li><strong>Request Deletion</strong> of data or account termination (where legally permissible)</li>
                        <li><strong>Object</strong> to or restrict certain types of processing</li>
                        <li><strong>Export</strong> or receive a copy of their data in a structured, machine-readable format</li>
                        <li><strong>File a Complaint</strong> with a data protection authority or regulatory body</li>
                    </ul>
                    <p>To initiate any such request, contact: <a href="mailto:support@myblackbag.com" >support@myblackbag.com</a></p>


                                                            
                    <h3>6. HIPAA and Regulatory Compliance</h3>
                    <p>BlackBag is engineered to support HIPAA-compliant workflows and the secure handling of PHI. A Business Associate Agreement (BAA) is available to covered entities and healthcare providers upon request. Compliance obligations may extend to other jurisdictions, including GDPR for users operating in the EU.</p>



                                                                                
                    <h3>7. Data Retention</h3>
                    <p>User data is retained only as long as necessary to fulfill the intended purpose or to comply with legal, regulatory, or contractual obligations. Upon account termination or user request, data will be securely deleted or anonymized, subject to applicable retention periods defined by law or professional ethics standards.</p>


                    <h3>8. Children’s Privacy</h3>
                    <p>The Platform is not intended for use by individuals under the age of 18. BlackBag does not knowingly collect or process data from children. If it is discovered that such information has been inadvertently collected, it will be deleted promptly.</p>


                    
                    <h3>9. Modifications to this Privacy Policy</h3>
                    <p>This Privacy Policy may be revised periodically. Any material changes will be communicated to users through the Platform or via email. Continued use of the Platform after the revised policy becomes effective constitutes acceptance of the updated terms. The “Effective Date” at the top of this document will reflect the most recent version.</p>

                     <h3>10. Contact Information</h3>
                     <p>For questions, concerns, or requests regarding this Privacy Policy or BlackBag’s data practices, contact:</p>
                    <p class="mb-1 "><strong>BlackBag – Privacy Team</strong></p>
                    <p class="mb-1 ">Email: <a href="mailto: legal@BlackBag.com" >legal@myblackbag.com</a></p>
                    <p >Website:  <a href="https://www.myblackbag.com/" target="_blank" >www.myblackbag.com</a></p>
                </div>
                
                </div>
            </div>
        </div>
    </div>
</section>

@endsection