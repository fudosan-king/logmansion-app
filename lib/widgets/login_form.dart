import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../blocs/authentication/authentication_event.dart';
import '../blocs/authentication/authentication_state.dart';
import '/blocs/authentication/authentication_bloc.dart';
import '/utils/validators.dart';

class LoginForm extends StatefulWidget {
  @override
  _LoginFormState createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  String? _emailError;
  String? _passwordError;

  @override
  Widget build(BuildContext context) {
    return BlocListener<AuthenticationBloc, AuthenticationState>(
      listener: (context, state) {
        if (state is AuthenticationFailure) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text(state.error),
              backgroundColor: Colors.red,
            ),
          );
        }
      },
      child: Padding(
        padding: EdgeInsets.all(20.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextFormField(
              controller: _emailController,
              decoration: InputDecoration(labelText: 'Email', errorText: _emailError),
              onFieldSubmitted: (value) {
                setState(() {
                  _emailError = Validators.emailValidator(value);
                });
              },
            ),
            TextFormField(
              controller: _passwordController,
              decoration: InputDecoration(labelText: 'Password', errorText: _passwordError),
              obscureText: true,
              onFieldSubmitted: (value) {
                setState(() {
                  _passwordError = Validators.passwordValidator(value);
                });
              },
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                if (_emailError == null && _passwordError == null) {
                  BlocProvider.of<AuthenticationBloc>(context).add(
                    AuthenticationLoginRequested(
                      email: _emailController.text.trim(),
                      password: _passwordController.text.trim(),
                    ),
                  );
                }
              },
              child: Text('Login'),
            ),
          ],
        ),
      ),
    );
  }
}