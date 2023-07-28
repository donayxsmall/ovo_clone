// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class OtpForgetPasswordScreen extends StatefulWidget {
  const OtpForgetPasswordScreen({Key? key}) : super(key: key);

  @override
  State<OtpForgetPasswordScreen> createState() =>
      _OtpForgetPasswordScreenState();
}

class _OtpForgetPasswordScreenState extends State<OtpForgetPasswordScreen> {
  List<String> otp = [];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      extendBodyBehindAppBar: true,
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        elevation: 0,
        leading: InkWell(
          onTap: () {
            Navigator.pop(context);
          },
          child: Image.asset('assets/image/arrow_back.png'),
        ),
      ),
      body: Stack(
        children: [
          Container(
            decoration: const BoxDecoration(
              image: DecorationImage(
                  image: AssetImage(
                    'assets/image/background_forget_password.png',
                  ),
                  fit: BoxFit.cover),
            ),
          ),
          Positioned(
            bottom: 0,
            child: Container(
              height: MediaQuery.of(context).size.height * 0.6,
              width: MediaQuery.of(context).size.width,
              decoration: const BoxDecoration(
                image: DecorationImage(
                    image: AssetImage(
                      'assets/image/gradient_body.png',
                    ),
                    fit: BoxFit.cover),
              ),
            ),
          ),
          Container(
            margin: EdgeInsets.only(
              top: MediaQuery.of(context).size.height * 0.06,
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Center(
                  child: Image.asset(
                    'assets/image/otp_forget.png',
                    width: 363,
                    height: 242,
                  ),
                ),
                const SizedBox(
                  height: 20.0,
                ),
                Container(
                  margin: const EdgeInsets.only(left: 30, right: 30),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        "OTP Verification",
                        style: TextStyle(
                          fontSize: 20.0,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const Text(
                        "An Authentication code has been sent to donayx****@gmail.com",
                        style: TextStyle(
                          fontSize: 12.0,
                          color: Color(0xff909090),
                          letterSpacing: 12 * 0.08,
                        ),
                      ),
                      const SizedBox(
                        height: 30.0,
                      ),
                      Center(
                        child: Column(
                          children: [
                            Text(
                              "Enter OTP",
                              style: TextStyle(
                                fontSize: 20.0,
                                fontWeight: FontWeight.bold,
                                color: primaryColor,
                              ),
                            ),
                            const SizedBox(
                              height: 10.0,
                            ),
                            OtpTextField(
                              numberOfFields: 4,
                              onChanged: (otpValues) {
                                otp = otpValues;
                              },
                            ),
                            const SizedBox(
                              height: 20.0,
                            ),
                            SizedBox(
                              width: 235,
                              height: 43,
                              child: ElevatedButton(
                                style: ElevatedButton.styleFrom(
                                    backgroundColor: primaryColor,
                                    shape: RoundedRectangleBorder(
                                        borderRadius:
                                            BorderRadius.circular(10))),
                                onPressed: () {
                                  if (otp.length < 4) {
                                    const snackBar = SnackBar(
                                      content: Text(
                                          'OTP tidak lengkap. mohon isi semua field'),
                                      backgroundColor: Colors.red,
                                    );
                                    ScaffoldMessenger.of(context)
                                        .showSnackBar(snackBar);
                                  } else {
                                    print(otp);
                                  }
                                },
                                child: const Text("Verify",
                                    style: TextStyle(
                                      color: Colors.white,
                                    )),
                              ),
                            ),
                          ],
                        ),
                      )
                    ],
                  ),
                )
              ],
            ),
          ),
        ],
      ),
    );
  }
}
