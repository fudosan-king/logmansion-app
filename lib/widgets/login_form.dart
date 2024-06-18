import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:formz/formz.dart';

import '../blocs/login/login_bloc.dart';
import '../blocs/login/login_event.dart';
import '../blocs/login/login_state.dart';


class LoginForm extends StatelessWidget {
  const LoginForm({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocListener<LoginBloc, LoginState>(
      listener: (context, state) {
        if (state.status.isFailure) {
          ScaffoldMessenger.of(context)
            ..hideCurrentSnackBar()
            ..showSnackBar(
              const SnackBar(content: Text('Authentication Failure')),
            );
        }
      },
      child: Align(
        alignment: const Alignment(0, -1 / 3),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            _UsernameInput(),
            const Padding(padding: EdgeInsets.all(12)),
            _PasswordInput(),
            const Padding(padding: EdgeInsets.all(12)),
            _LoginButton(),
          ],
        ),
      ),
    );
  }
}

class _UsernameInput extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
      buildWhen: (previous, current) => previous.clientID != current.clientID,
      builder: (context, state) {
        return TextField(
          key: const Key('loginForm_usernameInput_textField'),
          onChanged: (username) =>
              context.read<LoginBloc>().add(LoginUsernameChanged(username)),
          decoration: InputDecoration(
            labelText: 'username',
            errorText:
            state.clientID.displayError != null ? 'invalid username' : null,
          ),
        );
      },
    );
  }
}

class _PasswordInput extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
      buildWhen: (previous, current) => previous.password != current.password,
      builder: (context, state) {
        return TextField(
          key: const Key('loginForm_passwordInput_textField'),
          onChanged: (password) =>
              context.read<LoginBloc>().add(LoginPasswordChanged(password)),
          obscureText: true,
          decoration: InputDecoration(
            labelText: 'password',
            errorText:
            state.password.displayError != null ? 'invalid password' : null,
          ),
        );
      },
    );
  }
}

class _LoginButton extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<LoginBloc, LoginState>(
      builder: (context, state) {
        return state.status.isInProgress
            ? const CircularProgressIndicator()
            : ElevatedButton(
          key: const Key('loginForm_continue_raisedButton'),
          onPressed: state.isValid
              ? () {
            context.read<LoginBloc>().add(const LoginSubmitted());
          }
              : null,
          child: const Text('Login'),
        );
      },
    );
  }
}

// import 'package:flutter/material.dart';
// import 'package:flutter_bloc/flutter_bloc.dart';
//
// import '../blocs/authentication/authentication_event.dart';
// import '../blocs/authentication/authentication_state.dart';
// import '/blocs/authentication/authentication_bloc.dart';
// import '/utils/validators.dart';
//
// class LoginForm extends StatefulWidget {
//   @override
//   _LoginFormState createState() => _LoginFormState();
// }
//
// class _LoginFormState extends State<LoginForm> {
//   final _clientIDController = TextEditingController();
//   final _passwordController = TextEditingController();
//
//   String? _emailError;
//   String? _passwordError;
//
//   @override
//   Widget build(BuildContext context) {
//     return BlocListener<AuthenticationBloc, AuthenticationState>(
//       listener: (context, state) {
//         if (state is AuthenticationFailure) {
//           ScaffoldMessenger.of(context).showSnackBar(
//             SnackBar(
//               content: Text(state.error),
//               backgroundColor: Colors.red,
//             ),
//           );
//         }
//       },
//       child: Padding(
//         padding: EdgeInsets.all(20.0),
//         child: Column(
//           mainAxisAlignment: MainAxisAlignment.center,
//           children: [
//             TextFormField(
//               controller: _clientIDController,
//               decoration: InputDecoration(labelText: 'Email', errorText: _emailError),
//               onFieldSubmitted: (value) {
//                 setState(() {
//                   _emailError = Validators.emailValidator(value);
//                 });
//               },
//             ),
//             TextFormField(
//               controller: _passwordController,
//               decoration: InputDecoration(labelText: 'Password', errorText: _passwordError),
//               obscureText: true,
//               onFieldSubmitted: (value) {
//                 setState(() {
//                   _passwordError = Validators.passwordValidator(value);
//                 });
//               },
//             ),
//             SizedBox(height: 20),
//             ElevatedButton(
//               onPressed: () {
//                 if (_emailError == null && _passwordError == null) {
//                   BlocProvider.of<AuthenticationBloc>(context).add(
//                     AuthenticationLoginRequested(
//                       id: _clientIDController.text.trim(),
//                       password: _passwordController.text.trim(),
//                     ),
//                   );
//                 }
//               },
//               child: Text('Login'),
//             ),
//           ],
//         ),
//       ),
//     );
//   }
// }
//
//
//
// // import 'package:flutter/material.dart';
// // import 'package:flutter_bloc/flutter_bloc.dart';
// //
// // import '../blocs/authentication/authentication_event.dart';
// // import '../blocs/authentication/authentication_state.dart';
// // import '/blocs/authentication/authentication_bloc.dart';
// // import '/utils/validators.dart';
// //
// // class LoginForm extends StatefulWidget {
// //   @override
// //   _LoginFormState createState() => _LoginFormState();
// // }
// //
// // class _LoginFormState extends State<LoginForm> {
// //   final _clientIDController = TextEditingController();
// //   final _passwordController = TextEditingController();
// //
// //   String? _emailError;
// //   String? _passwordError;
// //
// //   @override
// //   Widget build(BuildContext context) {
// //     return BlocListener<AuthenticationBloc, AuthenticationState>(
// //       listener: (context, state) {
// //         if (state is AuthenticationFailure) {
// //           ScaffoldMessenger.of(context).showSnackBar(
// //             SnackBar(
// //               content: Text(state.error),
// //               backgroundColor: Colors.red,
// //             ),
// //           );
// //         }
// //       },
// //       child: Padding(
// //         padding: EdgeInsets.all(20.0),
// //         child: Column(
// //           mainAxisAlignment: MainAxisAlignment.center,
// //           children: [
// //             TextFormField(
// //               controller: _clientIDController,
// //               decoration: InputDecoration(labelText: 'Email', errorText: _emailError),
// //               onFieldSubmitted: (value) {
// //                 setState(() {
// //                   _emailError = Validators.emailValidator(value);
// //                 });
// //               },
// //             ),
// //             TextFormField(
// //               controller: _passwordController,
// //               decoration: InputDecoration(labelText: 'Password', errorText: _passwordError),
// //               obscureText: true,
// //               onFieldSubmitted: (value) {
// //                 setState(() {
// //                   _passwordError = Validators.passwordValidator(value);
// //                 });
// //               },
// //             ),
// //             SizedBox(height: 20),
// //             ElevatedButton(
// //               onPressed: () {
// //                 if (_emailError == null && _passwordError == null) {
// //                   BlocProvider.of<AuthenticationBloc>(context).add(
// //                     AuthenticationLoginRequested(
// //                       id: _clientIDController.text.trim(),
// //                       password: _passwordController.text.trim(),
// //                     ),
// //                   );
// //                 }
// //               },
// //               child: Text('Login'),
// //             ),
// //           ],
// //         ),
// //       ),
// //     );
// //   }
// // }
