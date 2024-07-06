// TERMS AND CONDITIONS
const terms = document.getElementById('terms_modal');
terms.addEventListener('click', (event) => {
    event.preventDefault();
    Swal.fire({
        title: 'Terms and Conditions',
        html:  '<div style="overflow-y: scroll; height: 350px;"> \
                <ul style="text-align: justify;font-size: 12pt;"> \
                <strong>Definition of terms: <br></strong> \
                <li> Trictech refers to the software and associated services provided by SD4B Students for managing TODA-related activities.</li> \
                <br><li>User refers to any individual or entity that accesses or uses the Trictech.</li> \
                <br><li>Library refers to the physical or virtual collection of resources managed by the Trictech.</li> \
                \
                <br><strong>Description of the service: <br></strong> \
                <br><li>The Trictech is designed to help TODA manage their collections and provide access to resources for their users. The system includes features such as cataloging, circulation, and reporting.</li> \
                \
                <br><strong>Use of the service: <br></strong> \
                <br><li>Users of the Trictech are required to follow all applicable laws and regulations, and to use the system only for lawful purposes. Users are prohibited from using the system to engage in any illegal or fraudulent activity, or to transmit any malicious or harmful content.</li> \
                \
                <br><strong>User responsibilities: <br></strong> \
                <br><li>Users are responsible for maintaining the confidentiality of their login credentials and for any activity that occurs under their account. Users must also ensure that their use of the Trictech does not infringe on the rights of any third party, including intellectual property rights.</li> \
                \
                <br><strong>Intellectual property: <br></strong> \
                <br><li>The Trictech and all associated content are the property of SD4B Students and are protected by copyright and other intellectual property laws. Users are granted a limited, non-exclusive, non-transferable license to use the system and its content for their own personal or business purposes.</li> \
                \
                <br><strong>Termination of the agreement: <br></strong> \
                <br><li>Either party may terminate the agreement at any time with written notice. Upon termination, users will no longer have access to the Trictech and must destroy any copies of the system or its content in their possession.</li> \
                \
                <br><strong>Liability: <br></strong> \
                <br><li>SD4B Students shall not be liable for any damages resulting from the use of the Trictech, including any loss of data or business interruption.</li> \
                \
                <br><strong>Changes to the terms: <br></strong> \
                <br><li>SD4B Students reserves the right to make changes to these terms and conditions at any time. Any changes will be effective immediately upon posting to the SD4B Students website.</li> \
                \
                <br><strong>Acceptance of the terms: <br></strong> \
                <br><li>By accessing or using the Trictech, users acknowledge that they have read and agree to be bound by these terms and conditions. If a user does not agree to these terms and conditions, they are not authorized to use the Trictech.</li> \
                </ul></div>',
        type: 'info'
    });
});

// PRIVACY POLICY
const privacy = document.getElementById('privacy_modal');
privacy.addEventListener('click', (event) => {
    event.preventDefault();
    Swal.fire({
        title: 'Privacy Policy',
        html:  '<div style="overflow-y: scroll; height: 350px;"> \
                <ul style="text-align: justify;font-size: 12pt;"> \
                <li> We will only collect personal data that is necessary for the provision of TODA services, and we will only use this data for the purposes for which it was collected.</li> \
                <br><li>We will take reasonable steps to protect the security of personal data collected through our Trictech, including by implementing appropriate technical and organizational measures.</li> \
                <br><li>Users of our Trictech have the right to access, correct, and delete their personal data at any time, subject to any legal restrictions. They also have the right to withdraw their consent to the collection and use of their personal data at any time, and to object to the processing of their personal data on grounds relating to their particular situation.</li> \
                <br><li>We will only retain personal data for as long as is necessary for the purposes for which it was collected, or as required by law. Once the personal data is no longer needed, we will securely delete it in accordance with our data retention policy.</li> \
                <br><li>Our Trictech may contain links to third-party websites or services. We are not responsible for the privacy practices of these third parties, and we encourage users to read the privacy policies of any third-party websites or services that they access.</li> \
                \
                </ul></div>',
        type: 'info'
    });
});

// Licensing
const license = document.getElementById('license_modal');
license.addEventListener('click', (event) => {
    event.preventDefault();
    Swal.fire({
        title: 'Licensing',
        html:  '<ul style="text-align: justify;font-size: 12pt;"> \
                <li>Our Trictech includes open source resources that are provided under various open source licenses. By using these resources, you agree to comply with the terms and conditions of the applicable open source license.</li></ul>',
        type: 'info'
    });
});

// COOKIE POLICY
const cookie = document.getElementById('cookie_modal');
cookie.addEventListener('click', (event) => {
    event.preventDefault();
    Swal.fire({
        title: 'Cookie Policy',
        html:  '<ul style="text-align: justify;font-size: 12pt;"> \
                <li>Our Trictech uses cookies to improve the user experience and to collect anonymous data on website usage. By continuing to use our website, you consent to the use of cookies in accordance with this policy.</li></ul>',
        type: 'info'
    });
});

// GROUP MEMBERS
const member = document.getElementById('member_modal');
member.addEventListener('click', (event) => {
    event.preventDefault();
    Swal.fire({
        title: 'TricTech',
        html:  '<ul style="text-align: justify;font-size: 13pt;"> \
                <strong>Members </strong><br>\
                <li>Bonggat, Airizh</li> \
                <li>De Ocampo, John Michael</li> \
                <li>Ison, Aira</li> \
                <li>Magpoc, Jermaine</li> \
                <li>Santos, Jason Erin</li> \
                </ul>',
        type: 'info'
    });
});