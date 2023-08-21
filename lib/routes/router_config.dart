import 'package:go_router/go_router.dart';
import 'package:ovo_clone/core.dart';

bool get loggedIn {
  final userLogin = Prefs.getMap('user');
  if (userLogin.isNotEmpty) {
    return true;
  } else {
    return false;
  }
}

final GoRouter goRouter = GoRouter(
  initialLocation: '/splash',
  debugLogDiagnostics: true,
  routerNeglect: true,
  // initialExtra: {
  //   'isLoggedIn': loggedIn,
  // },
  redirect: (context, state) {
    return null;

    // final userLogin = Prefs.getMap('user');
    // if (userLogin.isNotEmpty) {
    //   return '/dashboard';
    // }

    // return null;

    // if (loggedIn) {
    //   return '/dashboard';
    // }
    // return null;
  },
  routes: [
    GoRoute(
      path: '/login',
      name: 'login',
      redirect: (context, state) => loggedIn ? '/dashboard' : null,
      builder: (context, state) => const LoginScreen(),
      routes: [
        GoRoute(
            path: 'signup',
            name: 'signup',
            builder: (context, state) {
              OtpVerification(signup: Signup.init());
              return const SignUpScreen();
            },
            routes: [
              GoRoute(
                path: 'otp-verification',
                name: 'otp-verification',
                builder: (context, state) {
                  Object? object = state.extra;

                  if (object != null && object is Signup) {
                    return OtpVerification(
                      signup: object,
                    );
                  } else {
                    return OtpVerification(signup: Signup.init());
                  }
                },
              ),
              GoRoute(
                path: 'set-password',
                name: 'set-password',
                builder: (context, state) {
                  Object? object = state.extra;
                  if (object != null && object is Signup) {
                    return SetPasswordScreen(
                      signup: object,
                    );
                  } else {
                    return SetPasswordScreen(signup: Signup.init());
                  }
                },
              ),
            ]),
        GoRoute(
            path: 'password',
            name: 'password',
            builder: (context, state) {
              Object? object = state.extra;
              if (object != null && object is Auth) {
                return PasswordScreen(
                  item: object,
                );
              } else {
                return PasswordScreen(
                  item: Auth(email: "", password: ""),
                );
              }
            },
            routes: [
              GoRoute(
                  path: 'forget-password',
                  name: 'forget-password',
                  builder: (context, state) {
                    return const ForgetPasswordScreen();
                  },
                  routes: [
                    GoRoute(
                      path: 'otp-forget-password',
                      name: 'otp-forget-password',
                      builder: (context, state) {
                        Object? object = state.extra;
                        if (object != null && object is Auth) {
                          return OtpForgetPasswordScreen(
                            auth: object,
                          );
                        } else {
                          return OtpForgetPasswordScreen(auth: Auth.init());
                        }
                      },
                    ),
                    GoRoute(
                      path: 'reset-password',
                      name: 'reset-password',
                      builder: (context, state) {
                        Object? object = state.extra;
                        if (object != null && object is Auth) {
                          return ResetPasswordScreen(
                            auth: object,
                          );
                        } else {
                          return ResetPasswordScreen(auth: Auth.init());
                        }
                      },
                    )
                  ]),
            ]),
        GoRoute(
          path: 'help-center',
          name: 'help-center',
          builder: (context, state) {
            return const HelpCenterScreen();
          },
        ),
      ],
    ),
    GoRoute(
      path: '/splash',
      name: 'splash',
      builder: (context, state) => const SplashScreen(),
    ),
    GoRoute(
      path: '/dashboard',
      name: 'dashboard',
      redirect: (context, state) => !loggedIn ? '/login' : null,
      builder: (context, state) {
        return const MainNavigationScreen();
      },
      routes: [
        GoRoute(
          path: 'secure-code',
          name: 'secure-code',
          builder: (context, state) {
            return const SecureCodeScreen();
          },
        ),
      ],
    ),
  ],
);
