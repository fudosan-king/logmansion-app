import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:logmansion_app/screens/login/sign_in_screen.dart';

import 'blocs/authentication/authentication_bloc.dart';
import 'blocs/authentication/authentication_state.dart';
import 'repositories/authentication_repository.dart';
import 'repositories/user_repository.dart';
import 'screens/home.dart';
import 'screens/login_screen.dart';
import 'screens/splash/SplashScreen.dart';

class App extends StatefulWidget {
  const App({super.key});

  @override
  State<App> createState() => _AppState();
}

class _AppState extends State<App> {
  late final AuthenticationRepository _authenticationRepository;
  late final UserRepository _userRepository;

  @override
  void initState() {
    super.initState();
    _authenticationRepository = AuthenticationRepository();
    _userRepository = UserRepository();
  }

  @override
  void dispose() {
    _authenticationRepository.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return RepositoryProvider.value(
      value: _authenticationRepository,
      child: BlocProvider(
        create: (_) => AuthenticationBloc(
          authenticationRepository: _authenticationRepository,
          userRepository: _userRepository,
        ),
        child: const AppView(),
      ),
    );
  }
}

class AppView extends StatefulWidget {
  const AppView({super.key});

  @override
  State<AppView> createState() => _AppViewState();
}

class _AppViewState extends State<AppView> {
  final _navigatorKey = GlobalKey<NavigatorState>();

  NavigatorState get _navigator => _navigatorKey.currentState!;

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
      primarySwatch: Colors.blue,
      fontFamily: 'Plus Jakarta Sans',
      ),
      navigatorKey: _navigatorKey,
      builder: (context, child) {
        ScreenUtil.init(context, designSize: const Size(375, 812), minTextAdapt: true, splitScreenMode: true);
        return BlocListener<AuthenticationBloc, AuthenticationState>(
          listener: (context, state) {
            switch (state.status) {
              case AuthenticationStatus.authenticated:
                _navigator.pushAndRemoveUntil<void>(
                  Home.route(),
                      (route) => false,
                );
              case AuthenticationStatus.unauthenticated:
                _navigator.pushAndRemoveUntil<void>(
                  // LoginScreen.route(),
                  SignInScreen.route(),
                  (route) => false,
                );
              case AuthenticationStatus.unknown:
                break;
            }
          },
          child: child,
        );
      },
      onGenerateRoute: (_) => SplashScreen.route(),
    );
  }
}


// import 'package:flutter/material.dart';
// import 'package:flutter_bloc/flutter_bloc.dart';
// import 'package:flutter_screenutil/flutter_screenutil.dart';
// import 'blocs/authentication/authentication_bloc.dart';
// import 'repositories/authentication_repository.dart';
// import 'screens/login/sign_in_screen.dart';
// import 'screens/login_screen.dart';
// import 'screens/home.dart';
//
// class App extends StatelessWidget {
//   final AuthenticationRepository authenticationRepository;
//
//   const App({Key? key, required this.authenticationRepository})
//       : super(key: key);
//
//   @override
//   Widget build(BuildContext context) {
//     return RepositoryProvider.value(
//       value: authenticationRepository,
//       child: BlocProvider(
//         create: (context) =>
//             AuthenticationBloc(
//                 authenticationRepository: authenticationRepository),
//         child: ScreenUtilInit(
//           designSize: const Size(375, 812),
//           minTextAdapt: true,
//           splitScreenMode: true,
//           builder: (context, child) {
//             return MaterialApp(
//               title: 'Log Mansion',
//               debugShowCheckedModeBanner: false,
//               theme: ThemeData(
//                 primarySwatch: Colors.blue,
//                 fontFamily: 'Plus Jakarta Sans',
//               ),
//               initialRoute: '/home',
//               routes: {
//                 // '/': (context) => LoginScreen(),
//                 '/login': (context) => SignInScreen(),
//                 '/home': (context) => Home(),
//               },
//               // home: Home(),
//             );
//           },
//         ),
//       ),
//     );
//   }
// }
