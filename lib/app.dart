import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'blocs/authentication/authentication_bloc.dart';
import 'repositories/authentication_repository.dart';
import 'screens/login/signin_screen.dart';
import 'screens/login_screen.dart';
import 'screens/home.dart';

class App extends StatelessWidget {
  final AuthenticationRepository authenticationRepository;

  const App({Key? key, required this.authenticationRepository})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return RepositoryProvider.value(
      value: authenticationRepository,
      child: BlocProvider(
        create: (context) =>
            AuthenticationBloc(
                authenticationRepository: authenticationRepository),
        child: ScreenUtilInit(
          designSize: const Size(375, 812),
          minTextAdapt: true,
          splitScreenMode: true,
          builder: (context, child) {
            return MaterialApp(
              title: 'Log Mansion',
              debugShowCheckedModeBanner: false,
              theme: ThemeData(
                primarySwatch: Colors.blue,
                fontFamily: 'Plus Jakarta Sans',
              ),
              initialRoute: '/login',
              routes: {
                // '/': (context) => LoginScreen(),
                '/login': (context) => SignInScreen(),
                '/home': (context) => Home(),
              },
              // home: Home(),
            );
          },
        ),
      ),
    );
  }
}
