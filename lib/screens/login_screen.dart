import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:logmansion_app/blocs/authentication/authentication_state.dart';
import '/repositories/authentication_repository.dart';
import '/blocs/authentication/authentication_bloc.dart';
import '/widgets/login_form.dart';

class LoginScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Login'),
      ),
      body: BlocListener<AuthenticationBloc, AuthenticationState>(
        listener: (context, state) {
          if(state is AuthenticationSuccess){
            Navigator.of(context).pushReplacementNamed('/home');
          }
        },
        child: BlocProvider(
          create: (context) =>
              AuthenticationBloc(
                  authenticationRepository: AuthenticationRepository()),
          child: LoginForm(),
        ),
      ),
    );
  }
}