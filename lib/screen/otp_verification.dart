// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'dart:async';

import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import 'package:ovo_clone/core.dart';

class OtpVerification extends StatefulWidget {
  const OtpVerification({
    Key? key,
    required this.signup,
  }) : super(key: key);
  final Signup signup;

  @override
  State<OtpVerification> createState() => _OtpVerificationState();
}

class _OtpVerificationState extends State<OtpVerification> {
  List<String> otpList = [];
  String? otp;

  int _seconds = 10;
  late Timer _timer;

  @override
  void initState() {
    // TODO: implement initState
    _startTimer();
    super.initState();
  }

  void _startTimer() {
    _timer = Timer.periodic(const Duration(seconds: 1), (timer) {
      setState(() {
        if (_seconds > 0) {
          _seconds--;
        } else {
          _timer.cancel();
        }
      });
    });
  }

  void resendOtp() {
    print("resend otp");
    setState(() {
      _seconds = 60;
    });
    _startTimer();
  }

  void otpVerify() {
    otp = otpList.join();
    if (otpList.length < 4) {
      const snackBar = SnackBar(
        content: Text('OTP tidak lengkap. mohon isi semua field'),
        backgroundColor: Colors.red,
      );
      ScaffoldMessenger.of(context).showSnackBar(snackBar);
    } else {
      context.goNamed('set-password', extra: widget.signup);
    }
  }

  @override
  void dispose() {
    // TODO: implement dispose
    _timer.cancel();
    super.dispose();
  }

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
                      Text(
                        "An Authentication code has been sent to ${widget.signup.email}",
                        style: const TextStyle(
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
                                otpList = otpValues;
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
                                  otpVerify();
                                },
                                child: const Text("Verify",
                                    style: TextStyle(
                                      color: Colors.white,
                                    )),
                              ),
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(
                        height: 15.0,
                      ),
                      Center(
                        child: RichText(
                          text: TextSpan(
                            children: [
                              const TextSpan(
                                text: 'Resend OTP in ?',
                                style: TextStyle(
                                  fontSize: 13.0,
                                  color: Colors.black,
                                  fontWeight: FontWeight.w400,
                                ),
                              ),
                              TextSpan(
                                text: _seconds == 0
                                    ? ' Resend'
                                    : ' $_seconds seconds',
                                style: const TextStyle(
                                  fontSize: 13.0,
                                  color: Color(0xff00B0B7),
                                  fontWeight: FontWeight.w500,
                                ),
                                recognizer: TapGestureRecognizer()
                                  ..onTap = () {
                                    _seconds == 0 ? resendOtp() : null;
                                  },
                              )
                            ],
                          ),
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
