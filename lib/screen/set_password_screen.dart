// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';

import 'package:ovo_clone/core.dart';

class SetPasswordScreen extends StatefulWidget {
  const SetPasswordScreen({
    Key? key,
    required this.signup,
  }) : super(key: key);
  final Signup signup;

  @override
  State<SetPasswordScreen> createState() => _SetPasswordScreenState();
}

class _SetPasswordScreenState extends State<SetPasswordScreen> {
  String? password, confPassword;
  final _formKey = GlobalKey<FormState>();

  doSavePassword() async {
    final form = _formKey.currentState;
    if (form == null || !form.validate()) return;
    form.save();

    Signup signupfinal = widget.signup;
    signupfinal = widget.signup.copyWith(password: password);

    UserService().doLogin(signupfinal.toMap());

    context.goNamed('dashboard');

    const snackBar = SnackBar(
      content: Text('Success Signup'),
      backgroundColor: Colors.green,
    );
    ScaffoldMessenger.of(context).showSnackBar(snackBar);
  }

  @override
  Widget build(BuildContext context) {
    print(widget.signup);
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
      body: SingleChildScrollView(
        child: SafeArea(
          child: Stack(
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
                  top: MediaQuery.of(context).size.height * 0.04,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Center(
                      child: Image.asset(
                        'assets/image/set_password.png',
                        width: 369,
                        height: 280,
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
                            "Set Password",
                            style: TextStyle(
                              fontSize: 20.0,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          const Text(
                            "Create password for your account",
                            style: TextStyle(
                              fontSize: 12.0,
                              color: Color(0xff909090),
                              letterSpacing: 12 * 0.08,
                            ),
                          ),
                          const SizedBox(
                            height: 20.0,
                          ),
                          Form(
                            key: _formKey,
                            child: Column(
                              children: [
                                XPasswordField(
                                  label: 'Enter new password',
                                  icon: Icons.visibility,
                                  validator: Validator.password,
                                  onChanged: (value) {
                                    password = value;
                                  },
                                  onSaved: (value) {
                                    password = value;
                                  },
                                ),
                                const SizedBox(
                                  height: 10.0,
                                ),
                                XPasswordField(
                                  label: 'Enter confirm password',
                                  icon: Icons.phone_android,
                                  validator: (value) =>
                                      Validator.confirmPassword(
                                          value, password),
                                  onChanged: (value) {},
                                  onSaved: (value) {
                                    confPassword = value;
                                  },
                                ),
                              ],
                            ),
                          ),
                          const SizedBox(
                            height: 20.0,
                          ),
                          XButton(
                            label: 'Confirm',
                            onPressed: () {
                              doSavePassword();
                            },
                          ),
                          const SizedBox(
                            height: 20.0,
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
      ),
    );
  }
}
