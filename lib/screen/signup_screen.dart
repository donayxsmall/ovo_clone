// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:ovo_clone/core.dart';

class SignUpScreen extends StatefulWidget {
  const SignUpScreen({Key? key}) : super(key: key);

  @override
  State<SignUpScreen> createState() => _SignUpScreenState();
}

class _SignUpScreenState extends State<SignUpScreen> {
  final _formKey = GlobalKey<FormState>();
  String? email;
  String? phoneNumber;

  _sendOtp() {
    final form = _formKey.currentState;
    if (form == null || !form.validate()) return;
    form.save();
    final signup = Signup(email: email!, phone: phoneNumber!, password: '');
    print("email : $email , phone : $phoneNumber");

    context.goNamed('otp-verification', extra: signup);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
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
          Positioned(
            bottom: 1,
            left: 0,
            right: 0,
            child: Container(
              width: MediaQuery.of(context).size.width,
              height: MediaQuery.of(context).size.height * 0.4,
              decoration: const BoxDecoration(
                image: DecorationImage(
                  image: AssetImage(
                    'assets/image/gradient_body.png',
                  ),
                  fit: BoxFit.cover,
                ),
              ),
            ),
          ),
          SingleChildScrollView(
            child: SafeArea(
              child: SizedBox(
                width: MediaQuery.of(context).size.width,
                height: MediaQuery.of(context).size.height,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    SizedBox(
                      height: MediaQuery.of(context).size.height * 0.35,
                      child: Center(
                        child: Image.asset(
                          'assets/image/signup.png',
                          width: 347,
                        ),
                      ),
                    ),
                    const SizedBox(
                      height: 20.0,
                    ),
                    Container(
                      margin: const EdgeInsets.symmetric(
                          horizontal: 20, vertical: 10),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text(
                            "Sign Up",
                            style: TextStyle(
                              fontSize: 20.0,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                          const SizedBox(
                            height: 10.0,
                          ),
                          const Text(
                            "let’s get started with creating your account",
                            style: TextStyle(
                              fontSize: 12.0,
                              fontWeight: FontWeight.w600,
                              color: Color(0xff909090),
                              letterSpacing: 0.08 * 12,
                            ),
                          ),
                          const SizedBox(
                            height: 20.0,
                          ),
                          Form(
                            key: _formKey,
                            child: Column(
                              children: [
                                XTextField(
                                  label: 'Enter your e-mail ID',
                                  validator: Validator.email,
                                  icon: Icons.message,
                                  onChanged: (value) {},
                                  onSaved: (value) {
                                    email = value;
                                  },
                                ),
                                const SizedBox(
                                  height: 10.0,
                                ),
                                XNumberField(
                                  label: 'Enter your mobile number',
                                  validator: Validator.required,
                                  icon: Icons.phone_android,
                                  onChanged: (value) {},
                                  onSaved: (value) {
                                    phoneNumber = value;
                                  },
                                ),
                                const SizedBox(
                                  height: 20.0,
                                ),
                                XButton(
                                  label: 'SEND OTP',
                                  onPressed: () {
                                    _sendOtp();
                                  },
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(
                            height: 20.0,
                          ),
                          Center(
                            child: RichText(
                              text: TextSpan(
                                children: [
                                  const TextSpan(
                                    text: 'Already have account ?',
                                    style: TextStyle(
                                      fontSize: 13.0,
                                      color: Colors.black,
                                      fontWeight: FontWeight.w400,
                                    ),
                                  ),
                                  TextSpan(
                                    text: ' login',
                                    style: const TextStyle(
                                      fontSize: 13.0,
                                      color: Color(0xff00B0B7),
                                      fontWeight: FontWeight.w500,
                                    ),
                                    recognizer: TapGestureRecognizer()
                                      ..onTap = () {
                                        context.goNamed('login');
                                      },
                                  )
                                ],
                              ),
                            ),
                          )
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
