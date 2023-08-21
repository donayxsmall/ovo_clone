// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:go_router/go_router.dart';
import 'package:ovo_clone/core.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({Key? key}) : super(key: key);

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  TextEditingController emailController = TextEditingController();
  String? email;
  final _formKey = GlobalKey<FormState>();

  _submitForm() {
    if (!_formKey.currentState!.validate()) return false;
    _formKey.currentState!.save();

    context.goNamed(
      'password',
      extra: Auth(email: email!, password: ""),
    );

    // Get.offAll(PasswordScreen(item: Auth(email: email!, password: '')));
  }

  @override
  void dispose() {
    emailController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Stack(
      children: [
        Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
                image: AssetImage(
                  'assets/image/BACKGROUND.png',
                ),
                fit: BoxFit.cover),
          ),
        ),
        SizedBox(
          height: MediaQuery.of(context).size.height * 0.6,
          child: Center(
            child: SvgPicture.asset(
              'assets/image/logo_ovo.svg',
            ),
          ),
        ),
        Positioned(
          top: MediaQuery.of(context).size.height * 0.45,
          child: SizedBox(
            width: MediaQuery.of(context).size.width,
            child: Container(
              margin: const EdgeInsets.all(20.0),
              child: Column(
                children: [
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.end,
                    children: [
                      Container(
                        alignment: Alignment.center,
                        child: Image.asset('assets/image/person.png'),
                      ),
                      const SizedBox(
                        width: 10.0,
                      ),
                      Expanded(
                        child: Form(
                          key: _formKey,
                          child: TextFormField(
                            controller: emailController,
                            validator: Validator.email,
                            autovalidateMode:
                                AutovalidateMode.onUserInteraction,
                            style: const TextStyle(
                              color: Colors.white,
                            ),
                            decoration: const InputDecoration(
                              labelText: 'Enter your e-mail ID',
                              labelStyle: TextStyle(
                                color: Colors.white54,
                              ),
                              errorStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Colors.orange,
                              ),
                              enabledBorder: UnderlineInputBorder(
                                borderSide: BorderSide(color: Colors.white),
                              ),
                              focusedBorder: UnderlineInputBorder(
                                borderSide: BorderSide(color: Colors.white),
                              ),
                            ),
                            onSaved: (value) {
                              email = value;
                            },
                          ),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  SizedBox(
                    width: MediaQuery.of(context).size.width,
                    height: 45,
                    child: OutlinedButton(
                      style: OutlinedButton.styleFrom(
                          foregroundColor: Colors.white,
                          side: const BorderSide(
                            color: Colors.white,
                          ),
                          shape: const RoundedRectangleBorder(
                              borderRadius:
                                  BorderRadius.all(Radius.circular(30)))),
                      onPressed: () {
                        _submitForm();

                        // Router.neglect(
                        //     context, () => context.go('/otp_verification'));

                        // context.goNamed('otp');

                        // context.goNamed(
                        //   'password',
                        //   extra: Auth(email: "asasas", password: ""),
                        // );

                        // context.goNamed('otp');

                        // context.pushReplacementNamed('otp');

                        // Navigator.pushReplacement(
                        //   context,
                        //   MaterialPageRoute(
                        //       builder: (context) => PasswordScreen(
                        //           item: Auth(email: "asasas", password: ""))),
                        // );
                      },
                      child: const Text(
                        "SIGN IN",
                        style: TextStyle(
                          fontSize: 12.0,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  Container(
                    margin: const EdgeInsets.only(left: 20, right: 20),
                    child: const Row(
                      children: [
                        Expanded(
                          child: Divider(
                            thickness: 2,
                            color: Colors.white,
                          ),
                        ),
                        SizedBox(
                          width: 10.0,
                        ),
                        Text(
                          "OR",
                          style: TextStyle(
                            fontSize: 12.0,
                            color: Colors.white,
                          ),
                        ),
                        SizedBox(
                          width: 10.0,
                        ),
                        Expanded(
                          child: Divider(
                            thickness: 2,
                            color: Colors.white,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  SizedBox(
                    width: MediaQuery.of(context).size.width,
                    height: 45,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xff00B0B7),
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30))),
                      onPressed: () {
                        context.goNamed('signup');
                      },
                      child: const Text(
                        "SIGN UP",
                        style: TextStyle(
                          fontSize: 12.0,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(
                    height: 10.0,
                  ),
                  TextButton(
                    onPressed: () {
                      context.goNamed('help-center');
                    },
                    child: const Text(
                      "Need Help ?",
                      style: TextStyle(
                        fontSize: 12.0,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ],
    ));
  }
}
